<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurtidasTable extends Migration
{
    public function up()
    {
        Schema::create('curtidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('postagem_id'); // Chave estrangeira para 'postagens'
            $table->unsignedBigInteger('doador_id'); // Chave estrangeira para 'doador', ou a tabela correspondente ao usuário
            $table->timestamps();
            
            // Definindo as chaves estrangeiras
            $table->foreign('postagem_id')->references('idPostagem')->on('postagem')->onDelete('cascade');
            $table->foreign('doador_id')->references('idDoador')->on('doador')->onDelete('cascade'); // Ajuste o nome da tabela e coluna conforme necessário
        });
    }

    public function down()
    {
        Schema::dropIfExists('curtidas');
    }
}
