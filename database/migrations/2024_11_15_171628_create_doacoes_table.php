<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoacoesTable extends Migration
{
    public function up()
    {
        Schema::create('doacoes', function (Blueprint $table) {
            $table->id('idDoacao');
            $table->unsignedBigInteger('ongId'); // Relacionamento com a tabela ONG
            $table->decimal('valor', 15, 2);
            $table->integer('mes');
            $table->integer('ano');
            $table->timestamps();

            $table->foreign('ongId')->references('idOng')->on('ong')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doacoes');
    }
}
