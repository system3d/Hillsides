<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AaTamanhoField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('anexos', function (Blueprint $table) {
            $table->integer('tamanho')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('anexos', function (Blueprint $table) {
            $table->dropColumn('tamanho');
        });
    }
}
