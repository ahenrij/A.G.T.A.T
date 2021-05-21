<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('fonction');
            $table->string('telephone', 20)->unique();
            $table->string('adresse', 300);
            $table->string('login')->unique();
            $table->string('password');
            $table->string('profil');
            $table->integer('structure_id')->unsigned();
            $table->integer('type_user_id')->unsigned();
            $table->integer('groupe_id')->unsigned();

            $table->foreign('structure_id')
                ->references('id')
                ->on('structures')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('type_user_id')
                ->references('id')
                ->on('type_users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('groupe_id')
                ->references('id')
                ->on('groupes')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropForeign('users_structure_id_foreign');
            $table->dropForeign('users_type_user_id_foreign');
            $table->dropForeign('users_groupe_id_foreign');
        });
        Schema::drop('users');
    }
}
