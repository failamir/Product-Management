<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('purchase_code')->nullable();
            $table->datetime('purchase_date');
            $table->string('product_name');
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('unit_price', 15, 2);
            $table->float('discount', 15, 2)->nullable();
            $table->decimal('sub_total', 15, 2)->nullable();
            $table->float('total_discount', 15, 2)->nullable();
            $table->decimal('transport_cost', 15, 2)->nullable();
            $table->decimal('grand_total', 15, 2)->nullable();
            $table->decimal('total_paid', 15, 2);
            $table->string('payment_method')->nullable();
            $table->longText('purchase_note')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
