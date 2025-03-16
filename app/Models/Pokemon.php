<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemon';

    protected $fillable = [
        'nombre',
        'tipo',
        'stats',
        'nivel',
        'entrenador_id'
    ];

    public function entrenador(){
        return $this->belongsTo(Entrenador::class);
    }
}
