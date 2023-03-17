<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAjaxiProductTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('product_ajaxi_product_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('product_ajaxi_id');
            $table->foreign('product_ajaxi_id', 'product_ajaxi_id_fk_8197839')->references('id')->on('product_ajaxis')->onDelete('cascade');
            $table->unsignedBigInteger('product_tag_id');
            $table->foreign('product_tag_id', 'product_tag_id_fk_8197839')->references('id')->on('product_tags')->onDelete('cascade');
        });
    }
}
