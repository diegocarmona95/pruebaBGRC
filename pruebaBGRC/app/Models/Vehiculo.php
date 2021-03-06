<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiculo extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona', 'dueno', 'id');
    }

    public function vehiculo_historico()
    {
        return $this->hasMany('App\Models\HistoricoPersonaVehiculo');
    }
}
