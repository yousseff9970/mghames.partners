<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('getway_id')->nullable(); //payment getway id
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('payment_status')->default(2); //0=faild 1= approved 2=pending
            $table->unsignedBigInteger('status_id')->nullable();
            $table->double('tax')->default(0);
            $table->double('discount')->default(0);
            $table->double('total')->default(0);
            $table->string('order_method')->nullable(); 
            $table->integer('order_from')->default(1); //1=websiteend 2=api end 3= adminend 
            $table->string('notify_driver')->default('mail');//notification driver
            $table->timestamps();
            
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade'); 
            
            $table->foreign('getway_id')
            ->references('id')->on('getways')
            ->onDelete('cascade'); 

            $table->foreign('status_id')
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
        Schema::dropIfExists('orders');
    }
}
