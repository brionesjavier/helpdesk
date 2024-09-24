<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    // Define los campos que pueden ser asignados masivamente
    protected $fillable = [
        'ticket_id',
        'state_id',
        'change_state',
        'user_id',
        'action',
        'sla_time'
    ];

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

}
