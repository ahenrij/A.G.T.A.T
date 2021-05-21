<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('immatriculation')->unique();
            $table->string('marque', 200);
            $table->integer('type_vehicule_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('type_vehicule_id')
                ->references('id')
                ->on('type_vehicules')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicules', function (Blueprint $table){
            $table->dropForeign('vehicules_type_vehicule_id_foreign');
            $table->dropForeign('vehicules_user_id_foreign');
        });
        Schema::drop('vehicules');
    }
}
