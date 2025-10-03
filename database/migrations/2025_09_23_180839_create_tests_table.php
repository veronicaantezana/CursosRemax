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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->unique()->constrained('cursos')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('duracion')->default(30)->comment('Tiempo límite para completar el test en minutos');
            $table->decimal('calificacion',5,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
