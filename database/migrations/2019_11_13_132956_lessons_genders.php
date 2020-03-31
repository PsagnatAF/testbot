<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LessonsGenders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_genders', function (Blueprint $table) {
            $table->integer('lessons_id')->unsigned();
            $table->integer('genders_id')->unsigned();

            $table->foreign('lessons_id')->references('id')->on('lessons');
            $table->foreign('genders_id')->references('id')->on('genders');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
