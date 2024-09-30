<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\SlaTimeFormatter;

class History extends Model
{
    use HasFactory;
    use SlaTimeFormatter;
    // Define los campos que pueden ser asignados masivamente
    protected $fillable = [
        'ticket_id',
        'state_id',
        'change_state',
        'user_id',
        'action',
        'sla_time'
    ];

    public function getFormattedSla()
    {
        return $this->getSlaTimeFormattedAttribute($this->sla_time_interval);
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


}
