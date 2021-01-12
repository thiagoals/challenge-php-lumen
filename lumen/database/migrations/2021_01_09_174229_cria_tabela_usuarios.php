<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriaTabelaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('email')->unique()->notNullable();
            $table->string('senha');
            $table->timestamps();
        });

        //Inserindo usuário
        DB::table('usuarios')->insert(
            array(
                'email'=>'thiagoaaugustols@gmail.com',
                'nome'=>'Thiago Augusto',
                'senha'=>'e10adc3949ba59abbe56e057f20f883e' //123456
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
