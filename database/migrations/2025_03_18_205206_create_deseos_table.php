<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('deseos', function (Blueprint $table) {
            $table->id('id_deseos');

            // Relación con usuario (autenticación)
            $table->foreignId('id_usuario')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->string('nombre_deseos', 255);
            $table->text('descripcion');

            // Relación con categorías
            $table->foreignId('id_categoria')
                  ->constrained('categorias')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            // Relación con estados
            $table->foreignId('id_estado')
                  ->constrained('estados')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->timestamps();

            // Índices para mejorar el rendimiento
            $table->index('id_usuario');
            $table->index('id_categoria');
            $table->index('id_estado');
        });
    }

    public function down(): void {
        // Eliminar las claves foráneas primero
        Schema::table('deseos', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
            $table->dropForeign(['id_categoria']);
            $table->dropForeign(['id_estado']);
        });

        Schema::dropIfExists('deseos');
    }
};
