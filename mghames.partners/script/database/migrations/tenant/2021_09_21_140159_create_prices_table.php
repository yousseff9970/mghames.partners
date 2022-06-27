<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('term_id'); //product id
            $table->unsignedBigInteger('productoption_id')->nullable(); //group option id
            $table->unsignedBigInteger('category_id')->nullable(); //child attribute id
            $table->double('price')->nullable();
            $table->double('old_price')->nullable();
            $table->integer('qty')->nullable();
            $table->string('sku')->nullable();
            $table->double('weight')->nullable();
            $table->integer('stock_manage')->default(1);
            $table->integer('stock_status')->default(1);

            $table->foreign('term_id')
            ->references('id')->on('terms')
            ->onDelete('cascade'); 

            $table->foreign('productoption_id')
            ->references('id')->on('productoptions')
            ->onDelete('cascade'); 

            $table->foreign('category_id')
            ->references('id')->on('categories')
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
        Schema::dropIfExists('prices');
    }
}
