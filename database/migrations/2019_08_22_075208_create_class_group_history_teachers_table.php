<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassGroupHistoryTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_group_history_teacher', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('class_group_id')->unsigned()->nullable();
            $table->foreign('class_group_id')->references('id')->on('class_groups')->onDelete('cascade');
            $table->integer('history_teacher_id')->unsigned()->nullable();
            $table->foreign('history_teacher_id')->references('id')->on('history_teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_group_history_teacher');
    }
}
