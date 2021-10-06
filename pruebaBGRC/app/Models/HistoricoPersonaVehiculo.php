<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPersonaVehiculo extends Model
{
    use HasFactory;
    protected $table = 'historico_personas_vehiculos';

    /**
     * The vehiculos that belong to the HistoricoPersonaVehiculo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personas()
    {
        return $this->hasMany('App\Models\Persona', 'id', 'persona_id');
    }

    public function vehiculos()
    {
        return $this->hasMany('App\Models\Vehiculo', 'id', 'vehiculo_id');
    }
}
