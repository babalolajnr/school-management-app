<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchClassroomTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_classroom_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_classroom_id')->constrained('branch_classroom')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('branch_classroom_teacher');
    }
}
