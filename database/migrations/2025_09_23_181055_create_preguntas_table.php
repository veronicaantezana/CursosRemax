<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade');
            $table->text('enunciado');
            $table->enum('tipo', [
                'seleccion_unica',     
                'seleccion_multiple',   
                'verdadero_falso',     
                'respuesta_corta',     
                'respuesta_larga'      
            ])->default('seleccion_unica');
            $table->integer('orden')->default(0);
            $table->decimal('puntaje');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
