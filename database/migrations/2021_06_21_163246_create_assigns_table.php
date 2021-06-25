<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_grade");
            $table->unsignedBigInteger("id_subject");
            $table->unsignedBigInteger("id_teacher");
            $table->float("time_done")->default(0);
            $table->timestamps();
            $table->unique(["id_grade", "id_subject", "id_teacher"]);
            $table->foreign("id_grade")->references("id")->on("grades");
            $table->foreign("id_subject")->references("id")->on("subjects");
            $table->foreign("id_teacher")->references("id")->on("teachers");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assigns');
    }
}
