<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnPurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('return_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('return_reason');
            $table->datetime('return_date');
            $table->integer('refund_amount')->nullable();
            $table->longText('return_note')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
