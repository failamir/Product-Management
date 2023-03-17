<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToReturnPurchasesTable extends Migration
{
    public function up()
    {
        Schema::table('return_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('purchases_id')->nullable();
            $table->foreign('purchases_id', 'purchases_fk_8197893')->references('id')->on('purchases');
        });
    }
}
