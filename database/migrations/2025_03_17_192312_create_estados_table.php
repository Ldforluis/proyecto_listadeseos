<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB; // Importante incluir esto
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id('id_estado');
            $table->boolean('nombre_estado')->default(true);
            $table->timestamps();
        });

        // Insertar datos iniciales para estados
        DB::table('estados')->insert([
            ['nombre_estado' => true],   // true = Pendiente
            ['nombre_estado' => false]   // false = Cumplido
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
