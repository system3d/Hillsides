<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColorTarefa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos_tarefa', function (Blueprint $table) {
           $table->string('cor')->nullable();
        });

        Schema::table('tipos_tarefa_default', function (Blueprint $table) {
           $table->string('cor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipos_tarefa', function (Blueprint $table) {
           $table->dropColumn('cor')->nullable();
        });
        Schema::table('tipos_tarefa_default', function (Blueprint $table) {
           $table->dropColumn('cor')->nullable();
        });
    }
}
