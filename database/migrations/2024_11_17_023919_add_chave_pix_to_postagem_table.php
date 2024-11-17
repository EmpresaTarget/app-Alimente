<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChavePixToPostagemTable extends Migration
{
    public function up()
    {
        Schema::table('postagem', function (Blueprint $table) {
            $table->string('chavePix')->nullable()->after('numeroCurtidas'); // Adiciona a coluna chave_pix
        });
    }

    public function down()
    {
        Schema::table('postagem', function (Blueprint $table) {
            $table->dropColumn('chavePix'); // Remove a coluna chave_pix
        });
    }
}
