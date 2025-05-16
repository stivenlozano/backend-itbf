<?php

namespace App\Services;

use App\Models\Accommodation;

class AccommodationService
{
    public function getAll()
    {
        return Accommodation::all();
    }
}