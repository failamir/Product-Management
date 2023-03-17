<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Expense extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'expenses';

    public static $searchable = [
        'expense_date',
    ];

    protected $appends = [
        'expense_attachment_no_file_chosen',
    ];

    public const STATUS_SELECT = [
        'Active'   => 'Active',
        'InActive' => 'InActive',
    ];

    protected $dates = [
        'expense_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const EXPENSE_CATEGORY_SELECT = [
        'Stationary' => 'Stationary',
        'Rent'       => 'Rent',
    ];

    protected $fillable = [
        'expense_category',
        'expense_reason',
        'expense_amount',
        'expense_date',
        'expense_note',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getExpenseDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setExpenseDateAttribute($value)
    {
        $this->attributes['expense_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getExpenseAttachmentNoFileChosenAttribute()
    {
        return $this->getMedia('expense_attachment_no_file_chosen');
    }
}
