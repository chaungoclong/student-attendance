<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("email", 100);
            $table->string("password", 50);
            $table->tinyInteger("role")->default(0);
            $table->unsignedBigInteger("teacher_id")->nullable();
            $table->timestamps();
            $table->foreign("teacher_id")->references("id")->on("teachers");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
