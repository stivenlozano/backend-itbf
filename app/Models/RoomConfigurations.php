<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Accommodation;

class RoomConfiguration extends Model
{
    protected $table = 'room_configurations';
    
    protected $fillable = [
        'hotel_id',
        'room_type_id',
        'accommodation_id',
        'cantidad',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
