<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table="ticket_states";
    protected $fillable =['name'];

    use HasFactory;

    public function ticket(){
        return $this->hasMany(Ticket::class);
    }

   
}
