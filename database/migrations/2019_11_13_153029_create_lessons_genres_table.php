<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_genres', function (Blueprint $table) {
            $table->integer('lessons_id')->unsigned();
            $table->integer('genres_id')->unsigned();

            $table->foreign('lessons_id')->references('id')->on('lessons');
            $table->foreign('genres_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons_genres');
    }
}
