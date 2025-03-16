<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    use HasFactory;

    protected $table = 'entrenadores';

    protected $fillable = [
        'nombre', 
        'email', 
        'puntos', 
        'fecha_registro'
    ];
    protected $casts = [
        'fecha_registro' => 'date', 
    ];

    public function pokemon(){
        return $this->hasMany(Pokemon::class);
    }

    public function combatesComoEntrenador1(){
        return $this->hasMany(Combate::class, 'entrenador1_id');
    }

    public function combatesComoEntrenador2(){
        return $this->hasMany(Combate::class, 'entrenador2_id');
    }

    public function combates(){
        return $this->combatesComoEntrenador1->merge($this->combatesComoEntrenador2);
    }
}
