<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('tickets', function (Blueprint $table) {
        $table->timestamp('solved_at')->nullable()->after('updated_at');
        $table->timestamp('attention_deadline')->nullable(); //fecha limite del sla de asignacion
        $table->timestamp('sla_assigned_start_time')->nullable(); // Fecha de asignación
        $table->timestamp('sla_due_time')->nullable(); // Fecha límite del SLA de proceso

    });
}

public function down()
{
    Schema::table('tickets', function (Blueprint $table) {
        $table->dropColumn(['solved_at', 'attention_deadline','sla_assigned_start_time', 'sla_due_time']);
    });
}

};
