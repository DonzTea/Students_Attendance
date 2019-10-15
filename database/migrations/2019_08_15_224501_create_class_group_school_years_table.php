<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassGroupSchoolYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_group_school_year', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('class_group_id')->unsigned()->nullable();
            $table->foreign('class_group_id')->references('id')->on('class_groups')->onDelete('cascade');
            $table->bigInteger('school_year_id')->unsigned()->nullable();
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_group_school_year');
    }
}
