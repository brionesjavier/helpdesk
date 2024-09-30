<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\SlaTimeFormatter;
class Ticket extends Model
{
    use HasFactory;
    use SlaTimeFormatter;

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


    public function getSLAInMinutesOnCancellation()
    {
        // Verifica si no hay usuarios asignados y si el ticket ha sido resuelto.
        if ($this->assignedUsers->isEmpty() && $this->solved_at) {
            $assignedAt = Carbon::parse($this->created_at);
            $solvedAt = Carbon::parse($this->solved_at);
            return abs($assignedAt->diffInMinutes($solvedAt));
        }
        return null;
    } 

    




   // Otros métodos y propiedades del modelo

   public function getFormattedSla($seconds)
   {
       return $this->getSlaTimeFormattedAttribute($seconds);
   }

   


    public function getTotalSlaTime()
    {
        // Filtrar el historial donde change_state es true y sumar el tiempo de SLA
        $totalSlaSeconds = $this->history()
            ->where('change_state', true)
            ->sum('sla_time'); // 'sla_time' debe ser el nombre de la columna en tu tabla de historias


        return $this->getSlaTimeFormattedAttribute($totalSlaSeconds);
    }
}
