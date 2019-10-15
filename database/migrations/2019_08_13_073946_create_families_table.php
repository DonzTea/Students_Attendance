<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('live_with')->nullable();
            $table->string('economic_condition')->nullable();
            $table->string('learning_condition')->nullable();
            $table->tinyInteger('n_child')->nullable()->default('0');
            $table->tinyInteger('siblings_count')->nullable()->default('0');
            $table->tinyInteger('step_brothers_count')->nullable()->default('0');
            $table->tinyInteger('adopted_brothers_count')->nullable()->default('0');
            $table->tinyInteger('sibs_total')->nullable()->default('0');
            $table->string('used_language')->nullable();
            $table->bigInteger('student_id')->nullable()->unsigned();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->bigInteger('student_parent_id')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('families');
    }
}
