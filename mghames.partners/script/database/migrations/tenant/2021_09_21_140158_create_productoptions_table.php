<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productoptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('term_id'); //product id
            $table->unsignedBigInteger('category_id'); //attribute id
         
            $table->integer('select_type')->default(0); //1= multiple select 0= single select
            $table->integer('is_required')->default(0);


            $table->foreign('term_id')
            ->references('id')->on('terms')
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
        Schema::dropIfExists('productoptions');
    }
}
