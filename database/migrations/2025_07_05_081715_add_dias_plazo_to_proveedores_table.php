<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->integer('dias_plazo')->default(30)->after('saldo');
        });
    }

    public function down()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->dropColumn('dias_plazo');
        });
    }
};