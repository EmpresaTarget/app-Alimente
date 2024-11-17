<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campanha', function (Blueprint $table) {
            $table->string('chavePix')->nullable(); // Adiciona a coluna chavePix
        });
    }
    
    public function down()
    {
        Schema::table('campanha', function (Blueprint $table) {
            $table->dropColumn('chavePix'); // Remove a coluna chavePix se necessário
        });
    }
    
};
