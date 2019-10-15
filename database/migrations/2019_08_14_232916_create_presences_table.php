<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_id')->nullable()->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->string('date')->nullable();
            $table->string('info')->nullable();
            $table->bigInteger('class_group_id')->nullable()->unsigned();
            $table->foreign('class_group_id')->references('id')->on('class_groups')->onDelete('cascade');
            $table->bigInteger('school_year_id')->nullable()->unsigned();
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
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
        Schema::dropIfExists('presences');
    }
}
