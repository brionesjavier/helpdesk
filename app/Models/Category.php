<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // Nombre de la tabla en la base de datos
    protected $fillable = ['name', 'description']; // Campos que se pueden llenar
    
    use HasFactory;

    public function element(){
        return $this->hasMany(Element::class);
    }
}
