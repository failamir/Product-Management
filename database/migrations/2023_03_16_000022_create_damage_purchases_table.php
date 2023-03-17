<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamagePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('damage_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('damage_reason');
            $table->longText('damage_note')->nullable();
            $table->datetime('damage_date')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
