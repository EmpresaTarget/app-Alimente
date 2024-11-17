<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id('idComentario');
            $table->unsignedBigInteger('idPostagem');
            $table->unsignedBigInteger('idDoador');
            $table->text('conteudo');
            $table->timestamps();

            $table->foreign('idPostagem')->references('idPostagem')->on('postagem')->onDelete('cascade');
            $table->foreign('idDoador')->references('idDoador')->on('doador')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentarios');
    }

}
