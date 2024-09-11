<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{
    protected $table ='tickets';
    protected $fillable = ['title', 
                            'description', 
                            'element_id', 
                            'state_id',
                            'priority',
                            'created_by',
                            'is_active',
                            'solved_at',]; // Campos que se pueden llenar

    protected $casts = [
                        'solved_at' => 'datetime',];
    use HasFactory;

    public function state(){
        return $this->belongsTo(State::class);
    }
    public function element(){
        return $this->belongsTo(Element::class);
    }
    public function user(){
        return $this->belongsTo(User::class , 'created_by');
    }

    public function comment(){

        return $this->hasMany(Comment::class);
    }

    public function assignedUsers():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ticket_assigns')
                                                                ->withPivot('details', 'is_active')
                                                                ->withTimestamps();
    }
      /**
     * Obtener el SLA en minutos desde la creación del ticket.
     *
     * @return int
     */
    public function getSlaInMinutesAttribute()
    {
        $createdAt = $this->created_at;
        $now = Carbon::now();

        // Si la fecha de creación es en el futuro, utiliza el valor absoluto
        if ($createdAt > $now) {
            $minutes = abs($now->diffInMinutes($createdAt));
        } else {
            $minutes = abs($now->diffInMinutes($createdAt));
        }

        // Redondear a la unidad más cercana
        return round($minutes);
    }


    public function getSlaSolutionInMinutesAttribute()
    {
        // Verifica si hay al menos un usuario asignado
        if ($this->assignedUsers->isNotEmpty() && $this->solved_at) {
            // Obtén la fecha de asignación del primer usuario asignado
            $assignedAt = Carbon::parse($this->assignedUsers->first()->pivot->created_at);
            $solvedAt = Carbon::parse($this->solved_at);
            $minutes = abs($assignedAt->diffInMinutes($solvedAt));
    
            return round($minutes);
        }
    
        return null;
    }

}
