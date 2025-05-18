<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RoomConfiguration;

class RoomType extends Model
{
    protected $table = 'room_types';
    
    protected $fillable = [
        'nombre'
    ];

    public function roomConfigurations()
    {
        return $this->hasMany(RoomConfiguration::class);
    }
}
