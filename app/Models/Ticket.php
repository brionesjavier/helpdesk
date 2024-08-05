<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table ='tickets';
    protected $fillable = ['title', 'description', 'element_id', 'state_id','created_by']; // Campos que se pueden llenar
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

}
