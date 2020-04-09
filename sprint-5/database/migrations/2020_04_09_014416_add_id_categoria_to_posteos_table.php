<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCategoriaToPosteosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posteos', function (Blueprint $table) {
            $table->unsignedInteger("id_categoria");
            $table->foreign("id_categoria")->references("id")->on("categorias");
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

            $table->dropForeign("posteos_id_categoria_foreign");
            $table->dropColumn("id_categoria");
        });
    }
}
