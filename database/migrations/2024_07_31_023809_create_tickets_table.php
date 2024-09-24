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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high','critical'])->default('low');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('element_id')->constrained();
            $table->foreignId('state_id')->nullable()->constrained('ticket_states');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['element_id']);
            $table->dropForeign(['state_id']);
        });
        
        Schema::dropIfExists('tickets');
    }
};
