<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ave extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'nombre_ingles',
        'nombre_latin',
        'url',
        'fecha_registro',
    ];    

}
