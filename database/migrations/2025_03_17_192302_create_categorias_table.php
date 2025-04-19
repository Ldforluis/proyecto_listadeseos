<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- Añade esta línea

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre_categoria');
            $table->timestamps();
        });

        // Insertar datos iniciales
        DB::table('categorias')->insert([
            ['nombre_categoria' => 'Viajes'],
            ['nombre_categoria' => 'Tecnología'],
            ['nombre_categoria' => 'Hogar']
        ]);
}
};
