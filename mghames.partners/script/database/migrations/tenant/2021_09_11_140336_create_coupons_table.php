<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->string('code');
            $table->double('value');
            $table->integer('is_percentage')->default(1);
            $table->integer('is_conditional')->default(0);
            $table->double('min_amount')->default(0);
            $table->date('start_from');
            $table->date('will_expire');
            $table->integer('is_featured')->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('coupons');
    }
}
