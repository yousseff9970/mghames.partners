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
            $table->string('invoice_no');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('getway_id');
            $table->string('trx')->nullable();
            $table->integer('is_auto')->default(0); // 1 = recurring renew 0 =menual renew
            $table->double('tax')->nullable();
            $table->date('will_expire')->nullable();
            $table->double('price');          
            $table->integer('status')->default(2); //1= active 0=faild/cancel 2= pending 3=expired
            $table->integer('payment_status')->default(2); //1= active 0=faild/cancel 2= pending 3=expired
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('getway_id')->references('id')->on('getways')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
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
