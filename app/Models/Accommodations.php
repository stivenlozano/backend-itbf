<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RoomConfiguration;

class Accommodation extends Model
{
    public function roomConfigurations()
    {
        return $this->hasMany(RoomConfiguration::class);
    }
}