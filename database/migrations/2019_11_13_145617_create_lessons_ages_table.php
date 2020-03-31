<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsAgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_ages', function (Blueprint $table) {
            $table->integer('lessons_id')->unsigned();
            $table->integer('ages_id')->unsigned();

            $table->foreign('lessons_id')->references('id')->on('lessons');
            $table->foreign('ages_id')->references('id')->on('ages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons_ages');
    }
}
