<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCronoCustoSprint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sprints', function (Blueprint $table) {
           $table->date('inicio')->nullable();
           $table->date('termino')->nullable();
           $table->integer('custo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sprints', function (Blueprint $table) {
           $table->dropColumn('inicio')->nullable();
           $table->dropColumn('termino')->nullable();
           $table->dropColumn('custo')->nullable();
        });
    }
}
