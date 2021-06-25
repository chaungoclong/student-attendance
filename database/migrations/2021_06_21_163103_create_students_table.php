<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("name", 50);
            $table->date("date_birth");
            $table->tinyInteger("gender");
            $table->string("address", 50);
            $table->string('email', 100);
            $table->string('password', 50);
            $table->char("phone", 10);
            $table->unsignedBigInteger("id_grade");
            $table->timestamps();
            $table->foreign("id_grade")->references("id")->on("grades");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
