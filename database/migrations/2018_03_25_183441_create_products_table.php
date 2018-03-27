<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->text('description');
            $table->string('sku',64);
            $table->string('lot',64);
            $table->integer('category_id')->unsigned();
            $table->integer('manufacturer_id')->unsigned();
            $table->string('image')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('price')->default(0);
            $table->boolean('status')->default(0);
            $table->integer('viewed')->default(0);
            $table->timestamps();
        });

        Schema::table('products', function($table) {
            $table->foreign('category_id')->references('id')->on('categories');
        });
        Schema::table('products', function($table) {
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
