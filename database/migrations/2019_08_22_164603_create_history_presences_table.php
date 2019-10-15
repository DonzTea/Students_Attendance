<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_presences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('history_student_id')->nullable()->unsigned();
            $table->string('date')->nullable();
            $table->string('info')->nullable();
            $table->bigInteger('class_group_id')->nullable()->unsigned();
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
        Schema::dropIfExists('history_presences');
    }
}
