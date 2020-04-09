<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUserToPosteosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posteos', function (Blueprint $table) {
            $table->unsignedInteger("id_user");
            $table->foreign("id_user")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posteos', function (Blueprint $table) {
            $table->dropForeign("posteos_id_user_foreign");
            $table->dropColumn("id_user");
        });
    }
}
