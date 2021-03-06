<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function vehiculos()
    {
        return $this->hasMany('App\Models\Vehiculo');
    }
    public function persona_historico()
    {
        return $this->hasMany('App\Models\HistoricoPersonaVehiculo');
    }
}
