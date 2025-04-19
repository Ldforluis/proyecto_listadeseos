<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('deseos', function (Blueprint $table) {
            $table->id('id_deseos');
            $table->unsignedBigInteger('id_usuario');
            $table->string('nombre_deseos');
            $table->text('descripcion');
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_estado');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
            $table->foreign('id_estado')->references('id_estado')->on('estados')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('deseos');
    }
};
