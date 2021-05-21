<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {

        Schema::create('titres', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->bigInteger('numero')->unique();
            $table->integer('duree');
            $table->dateTime('date_delivrance');
            $table->boolean('demande')->default(false);
            $table->enum('etat', array('N','V'));
            $table->double('cout')->unsigned();
            $table->enum('piece', array('CNI', 'PSP'));
            $table->integer('zone_id')->unsigned();
            $table->integer('type_titre_id')->unsigned();
            $table->integer('agent_id')->unsigned();
            $table->integer('usager_id')->unsigned();

            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('type_titre_id')->references('id')->on('type_titres')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('usager_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('titres', function (Blueprint $table){
            $table->dropForeign('titres_agent_id_foreign');
            $table->dropForeign('titres_usager_id_foreign');
        });
        Schema::drop('titres');
    }
}
