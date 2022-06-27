<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gateway_id');
            $table->string('trx')->nullable();
            $table->string('type')->default(1);//0 = manual 1 = auto
            $table->double('amount');          
            $table->integer('status')->default(2); //1= active 0=faild/cancel 2= pending 3=expired
            $table->integer('payment_status')->default(2); //1= active 0=faild/cancel 2= pending 3=expired
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('meta')->nullable();
            $table->foreign('gateway_id')->references('id')->on('getways')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('deposits');
    }
}
