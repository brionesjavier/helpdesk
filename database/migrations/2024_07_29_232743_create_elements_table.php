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
        Schema::create('elements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->boolean('is_active')->default(true);
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('elements', function (Blueprint $table) {
            // Eliminar claves foráneas antes de eliminar la tabla
            $table->dropForeign(['category_id']);
        });


        Schema::dropIfExists('elements');
    }
};
