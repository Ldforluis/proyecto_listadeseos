<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('deseos', function (Blueprint $table) {
            $table->id('id_deseos');
            $table->unsignedBigInteger('id_usuario');
            $table->string('nombre_deseos', 255);
            $table->text('descripcion');
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_estado'); // Cambiado a id_estado para consistencia
            $table->timestamps();

            // Claves foráneas con nombres explícitos
            $table->foreign('id_usuario', 'fk_deseos_usuario')
                  ->references('id')->on('users') // Cambiado a 'users' si es la tabla estándar de Laravel
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_categoria', 'fk_deseos_categoria')
                  ->references('id_categoria')->on('categorias')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_estado', 'fk_deseos_estado')
                  ->references('id_estado')->on('estados')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('deseos');
    }
};

