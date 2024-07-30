<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $table = 'elements'; // Nombre de la tabla en la base de datos
    protected $fillable = ['name', 'description','category_id']; // Campos que se pueden llenar
    use HasFactory;
}
