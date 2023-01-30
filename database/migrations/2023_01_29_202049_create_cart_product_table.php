<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->timestamps();

            $table
                ->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onDelete('cascade');
            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_product');
    }
}
