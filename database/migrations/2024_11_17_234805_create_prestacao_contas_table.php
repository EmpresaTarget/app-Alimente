<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestacaoContasTable extends Migration
{
    public function up()
    {
        Schema::create('prestacao_contas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idOng');
            $table->string('balanco')->nullable();
            $table->string('demonstracao')->nullable();
            $table->string('receitas')->nullable();
            $table->string('despesas')->nullable();
            $table->string('foto1')->nullable();
            $table->string('foto2')->nullable();
            $table->string('foto3')->nullable();
            $table->string('foto4')->nullable();
            $table->string('foto5')->nullable();
            $table->foreign('idOng')->references('idOng')->on('ong')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestacao_contas');
    }
}
