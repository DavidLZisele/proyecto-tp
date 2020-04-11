<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdAmigoToAmigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amigos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_amigo');
            $table->foreign('id_amigo')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amigos', function (Blueprint $table) {
            $table->dropForeign('amigos_id_amigo_foreign');
            $table->dropColumn('id_user');
        });
    }
}
