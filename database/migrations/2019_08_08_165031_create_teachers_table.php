<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('nip')->nullable()->unique();
            $table->string('karpeg')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthday')->nullable();
            $table->tinyInteger('position_id')->nullable()->unsigned();
            $table->string('type')->nullable();
            $table->bigInteger('homeroom_teacher_of')->unsigned()->nullable();
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
        Schema::dropIfExists('teachers');
    }
}
