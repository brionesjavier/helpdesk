<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    use HasFactory;
    // Define los campos que pueden ser asignados masivamente
    protected $fillable = [
        'ticket_id',
        'user_id',
        'state_ticket',
        'content',
    ];

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
