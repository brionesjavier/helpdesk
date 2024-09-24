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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('state_id')->nullable()->constrained('ticket_states');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('change_state')->default(false);
            $table->integer('sla_time')->nullable(); // Tiempo de SLA en minutos
            $table->string('action');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
