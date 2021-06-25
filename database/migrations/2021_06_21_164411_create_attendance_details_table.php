<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_attendance");
            $table->unsignedBigInteger("id_student");
            $table->boolean("status");
            $table->timestamps();
            $table->unique(["id_attendance", "id_student"]);
            $table->foreign("id_attendance")->references("id")->on("attendances");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_details');
    }
}
