<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegramusers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('telegram_id');
            $table->string('name');
            $table->integer('genders_id')->nullable();
            $table->integer('ages_id')->nullable();
            $table->integer('englevels_id')->nullable();
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
        Schema::dropIfExists('telegramusers');
    }
}
