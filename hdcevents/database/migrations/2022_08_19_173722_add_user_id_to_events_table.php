<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            
            $table->foreignId('user_id')->constrained();
            //constrained(): entende que toda essa logica acima é para adicionar uma chave estrangeira na tabela 'user_id'
            //e atrela ela à um usuário de outra tabela

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            
            //removendo user_id quando for deletado
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            //deletando os regstros atrelados à esses usuários para não ficar um 'filho' sem 'pai'
            //ou seja, um usuário sem evento

        });
    }
}
