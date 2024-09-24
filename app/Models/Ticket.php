<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'title',
        'description',
        'element_id',
        'state_id',
        'priority',
        'created_by',
        'is_active',
        'solved_at',
        'attention_deadline',   // Tiempo para SLA de atencion
        'sla_assigned_start_time',   // Tiempo de inicio después de la asignación
        'sla_due_time' //tiempo para sla de proceso
    ];

    protected $casts = [
        'solved_at' => 'datetime',
        'attention_deadline' => 'datetime',
        'sla_assigned_start_time' => 'datetime',
        'sla_due_time' => 'datetime'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    public function history(){
        return $this->hasMany(History::class);
    }

    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ticket_assigns')
            ->withPivot('details', 'is_active')
            ->withTimestamps();
    }

    /**
     * Obtener el SLA en minutos desde la creación del ticket.
     */
    public function getSlaInMinutesAttribute()
    {
        $createdAt = $this->created_at;
        $now = Carbon::now();


        $minutes = abs($now->diffInMinutes($createdAt));

        // Verifica si hay un SLA por cancelación
        $sla = $this->getSLAInMinutesOnCancellation();
        return $sla !== null ? $sla : round($minutes);
    }

    public function getSlaSolutionInMinutesAttribute()
    {
        // Verifica si hay al menos un usuario asignado
        if ($this->assignedUsers->isNotEmpty() && $this->solved_at) {
            $assignedAt = Carbon::parse($this->assignedUsers->first()->pivot->created_at);
            $solvedAt = Carbon::parse($this->solved_at);
            return round(abs($assignedAt->diffInMinutes($solvedAt)));
        }

        return $this->getSLAInMinutesOnCancellation();
    }

    public function getSLAInMinutesOnCancellation()
    {
        // Verifica si no hay usuarios asignados y si el ticket ha sido resuelto.
        if ($this->assignedUsers->isEmpty() && $this->solved_at) {
            $assignedAt = Carbon::parse($this->created_at);
            $solvedAt = Carbon::parse($this->solved_at);
            return round(abs($assignedAt->diffInMinutes($solvedAt)));
        }
        return null;
    }

    /**
     * Calcula el tiempo en minutos entre la creación del ticket y la asignación.
     *
     * @return int|null Devuelve la diferencia en minutos, o null si no es aplicable.
     */
    public function getSlaAttention()
    {
        
        if ($this->created_at && $this->sla_assigned_start_time) {
            $attention = Carbon::parse($this->created_at)->diffInMinutes($this->sla_assigned_start_time);
            return abs(round($attention));
        }
        return null; // O considera return 0 si prefieres manejar 0 minutos en lugar de null.
    }

    public function getSlaResolutionTime()
    {
        if ($this->sla_assigned_start_time && $this->solved_at) {
            return Carbon::parse($this->sla_assigned_start_time)
                ->diffInMinutes($this->solved_at);
        }
        return null;
    }

    public function getTotalSlaTime()
{
    // Filtrar el historial donde change_state es true y sumar el tiempo de SLA
    return $this->history()
        ->where('change_state', true)
        ->sum('sla_time'); // 'sla_time' debe ser el nombre de la columna en tu tabla de historias
}
}
