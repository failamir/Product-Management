<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDamagePurchasesTable extends Migration
{
    public function up()
    {
        Schema::table('damage_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('purchases_id')->nullable();
            $table->foreign('purchases_id', 'purchases_fk_8197901')->references('id')->on('purchases');
        });
    }
}
