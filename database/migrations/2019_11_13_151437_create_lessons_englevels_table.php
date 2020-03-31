<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsEnglevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_englevels', function (Blueprint $table) {
            $table->integer('lessons_id')->unsigned();
            $table->integer('englevels_id')->unsigned();

            $table->foreign('lessons_id')->references('id')->on('lessons');
            $table->foreign('englevels_id')->references('id')->on('englevels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons_englevels');
    }
}
