<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('deseos', function (Blueprint $table) {
            $table->id('id_deseos');
        
            $table->foreignId('id_usuario')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        
            $table->string('nombre_deseos', 255);
            $table->text('descripcion');
        
            // ---- CATEGORÍAS ----
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')
                  ->references('id_categoria')     // <-- este nombre
                  ->on('categorias')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        
            // ---- ESTADOS ----
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_estado')
                  ->references('id_estado')       // <-- este nombre
                  ->on('estados')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        
            $table->timestamps();
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
