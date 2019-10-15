<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->integer('region_id')->unsigned()->nullable();
            $table->string('birthday')->nullable();
            $table->string('address')->nullable();
            $table->bigInteger('student_parent_id')->nullable()->unsigned();
            $table->tinyInteger('religion_id')->nullable()->unsigned();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->tinyInteger('class_group_id')->nullable()->unsigned();
            $table->bigInteger('school_year_id')->nullable()->unsigned();
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
        Schema::dropIfExists('history_students');
    }
}
