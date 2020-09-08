<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionandoCamposOrdem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_de_servicos', function (Blueprint $table) {
            $table->dateTime('data_entrada')->nullable();
            $table->dateTime('data_previsao')->nullable();
            $table->dateTime('data_entrega')->nullable();
            $table->string('situacao')->nullable();
            $table->decimal('valor', 5, 2)->nullable();
            $table->string('equipamento')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('garantia')->nullable();
            $table->text('observacoes')->nullable();
            $table->json('servicos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordem_de_servicos', function (Blueprint $table) {
            $table->dropColumn(['data_entrada', 'data_previsao', 'data_entrega', 'situacao', 'valor', 'equipamento', 'marca', 'modelo', 'numero_serie', 'garantia', 'observacoes', 'servicos']);
        });
    }
}
