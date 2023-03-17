<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAjaxiProductCategoryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('product_ajaxi_product_category', function (Blueprint $table) {
            $table->unsignedBigInteger('product_ajaxi_id');
            $table->foreign('product_ajaxi_id', 'product_ajaxi_id_fk_8197838')->references('id')->on('product_ajaxis')->onDelete('cascade');
            $table->unsignedBigInteger('product_category_id');
            $table->foreign('product_category_id', 'product_category_id_fk_8197838')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }
}
