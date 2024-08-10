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

        Schema::table('ticket_assigns', function (Blueprint $table) {
            $table->boolean('is_active')->default(true); // Campo para indicar si la asignación está activa
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_assigns', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
