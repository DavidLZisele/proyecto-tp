<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amigos', function (Blueprint $table) {
            $table->unsignedInteger("id_user");
            $table->unsignedInteger("id_amigo");
            $table->timestamps();
            $table->integer('respuesta');
            $table->primary(["id_user","id_amigo"]);
            $table->foreign('id_user')->references("id")->on("users");
            $table->foreign('id_amigo')->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amigos');
    }
}