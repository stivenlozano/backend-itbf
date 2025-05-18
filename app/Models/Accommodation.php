<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RoomConfiguration;

class Accommodation extends Model
{
    protected $table = 'accommodations';
    
    protected $fillable = [
        'nombre'
    ];

    public function roomConfigurations()
    {
        return $this->hasMany(RoomConfiguration::class);
    }
}
