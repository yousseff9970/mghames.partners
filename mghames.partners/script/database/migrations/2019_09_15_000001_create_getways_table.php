<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGetwaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('getways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->double('rate')->default(1);
            $table->double('charge')->default(0);
            $table->string('namespace');
            $table->string('currency_name');
            $table->integer('is_auto')->default(0);
            $table->integer('image_accept')->default(0);
            $table->integer('test_mode')->default(0);
            $table->integer('status')->default(1);
            $table->integer('phone_required')->default(0);
            $table->text('data');
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
        Schema::dropIfExists('getways');
    }
}
