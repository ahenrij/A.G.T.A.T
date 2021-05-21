<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeTitresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_titres', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->enum('code',array('BT','MT'));
            $table->string('libelle')->unique();
            $table->integer('duree')->unsigned();
            $table->double('prix');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('type_titres');
    }
}
