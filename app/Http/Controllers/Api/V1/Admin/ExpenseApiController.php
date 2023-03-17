<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\Admin\ExpenseResource;
use App\Models\Expense;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource(Expense::all());
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->all());

        foreach ($request->input('expense_attachment_no_file_chosen', []) as $file) {
            $expense->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('expense_attachment_no_file_chosen');
        }

        return (new ExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Expense $expense)
    {
        abort_if(Gate::denies('expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource($expense);
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->all());

        if (count($expense->expense_attachment_no_file_chosen) > 0) {
            foreach ($expense->expense_attachment_no_file_chosen as $media) {
                if (! in_array($media->file_name, $request->input('expense_attachment_no_file_chosen', []))) {
                    $media->delete();
                }
            }
        }
        $media = $expense->expense_attachment_no_file_chosen->pluck('file_name')->toArray();
        foreach ($request->input('expense_attachment_no_file_chosen', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $expense->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('expense_attachment_no_file_chosen');
            }
        }

        return (new ExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Expense $expense)
    {
        abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
