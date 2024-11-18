<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResetTokenToDoadorTable extends Migration
{
    public function up()
    {
        Schema::table('doador', function (Blueprint $table) {
            $table->string('reset_token', 255)->nullable()->after('biografiaDoador');
        });
    }

    public function down()
    {
        Schema::table('doador', function (Blueprint $table) {
            $table->dropColumn('reset_token');
        });
    }
}
