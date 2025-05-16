<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RoomConfiguration;

class Hotel extends Model
{
    protected $table = 'hotels';
    
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'nit',
        'max_habitaciones'
    ];

    public function roomConfigurations()
    {
        return $this->hasMany(RoomConfiguration::class);
    }
}
