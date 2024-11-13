<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalArrecadadoToOngTable extends Migration
{
    public function up()
{
    Schema::table('ong', function (Blueprint $table) {
        $table->decimal('totalArrecadado', 15, 2)->default(0.00)->after('estadoOng');
    });
}

public function down()
{
    Schema::table('ong', function (Blueprint $table) {
        $table->dropColumn('totalArrecadado');
    });
}

}
