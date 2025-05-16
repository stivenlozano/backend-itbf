<?php

namespace App\Services;

use App\Models\RoomType;

class RoomTypeService
{
    public function getAll()
    {
        return RoomType::all();
    }
}