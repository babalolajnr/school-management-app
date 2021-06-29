<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTeacherSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_teacher_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->unsigned()->unique();
            $table->integer('teacher_id')->nullable()->unsigned()->unique();
            $table->boolean('dark_mode');
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
        Schema::dropIfExists('user_teacher_settings');
    }
}
