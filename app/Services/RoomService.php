<?php

namespace App\Services;

use App\Models\RoomConfiguration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;


class RoomService
{
    public function getAll($id)
    {
        $data = DB::table('room_configurations')
        ->join('hotels', 'room_configurations.hotel_id', '=', 'hotels.id')
        ->join('room_types', 'room_configurations.room_type_id', '=', 'room_types.id')
        ->join('accommodations', 'room_configurations.accommodation_id', '=', 'accommodations.id')
        ->where('room_configurations.hotel_id', $id)
        ->select(
            'room_configurations.id',
            'hotels.nombre as hotel',
            'room_types.nombre as tipo_habitacion',
            'accommodations.nombre as acomodacion',
            'room_configurations.cantidad'
        )
        ->get(); 

        return $data;
    }

    public function getById($id)
    {
        $data = DB::table('room_configurations')
        ->join('hotels', 'room_configurations.hotel_id', '=', 'hotels.id')
        ->join('room_types', 'room_configurations.room_type_id', '=', 'room_types.id')
        ->join('accommodations', 'room_configurations.accommodation_id', '=', 'accommodations.id')
        ->where('room_configurations.id', $id)
        ->select(
            'room_configurations.id',
            'room_configurations.room_type_id as id_tipo_habitacion',
            'room_types.nombre as tipo_habitacion',
            'room_configurations.accommodation_id as id_acomodacion',
            'accommodations.nombre as acomodacion',
            'room_configurations.cantidad'
        )
        ->first(); 

        return $data;
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'accommodation_id' => 'required|exists:accommodations,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $validator->after(function ($validator) use ($data) {
            $hotelId = $data['hotel_id'];
            $roomTypeId = $data['room_type_id'];
            $accommodationId = $data['accommodation_id'];    
            
            $roomType = DB::table('room_types')->where('id', $roomTypeId)->value('nombre');
            $accommodation = DB::table('accommodations')->where('id', $accommodationId)->value('nombre');

            if (!$roomType || !$accommodation) {
                $validator->errors()->add('accommodation_id', 'La combinación especificada no es válida.');
                return;
            }

            // Validar duplicado
            $exists = DB::table('room_configurations')
                ->where('hotel_id', $hotelId)
                ->where('room_type_id', $roomTypeId)
                ->where('accommodation_id', $accommodationId)
                ->exists();
            
            if ($exists) {
                $validator->errors()->add('accommodation_id', 'Esta combinación ya existe para este hotel.');
                return;
            }

            // Validar suma de habitaciones
            $cantidadNueva = $data['cantidad'] ?? 0;
            $maxHabitaciones = DB::table('hotels')->where('id', $hotelId)->value('max_habitaciones');
            $sumaHabitaciones = DB::table('room_configurations')->where('hotel_id', $hotelId)->sum('cantidad');
            $total = $sumaHabitaciones + $cantidadNueva;

            if ($total > $maxHabitaciones) {
                $validator->errors()->add('cantidad', "La suma total de habitaciones excede el máximo permitido para el hotel.");
                return;
            }

            // Validar combinación lógica
            $valid = [
                'Estándar' => ['Sencilla', 'Doble'],
                'Junior' => ['Triple', 'Cuádruple'],
                'Suite' => ['Sencilla', 'Doble', 'Triple'],
            ];

            if (!isset($valid[$roomType]) || !in_array($accommodation, $valid[$roomType])) {
                $validator->errors()->add('accommodation_id', "La acomodación '{$accommodation}' no es válida para el tipo '{$roomType}'.");
            }
        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return RoomConfiguration::create($data);
    }

    public function update($id, array $data)
    {
        $RoomConfiguration = RoomConfiguration::find($id);
        
        if (!$RoomConfiguration) {
            throw new \Exception('Habitación no encontrada');
        }

        $rules = [
            'hotel_id' => ['required', 'exists:hotels,id'],
            'room_type_id' => ['required', 'exists:room_types,id'],
            'accommodation_id' => ['required', 'exists:accommodations,id'],
            'cantidad' => ['required', 'integer', 'min:1']
        ];
        
        $validator = Validator::make($data, $rules);

        $validator->after(function ($validator) use ($data, $RoomConfiguration) {
            $hotelId = $data['hotel_id'];
            $roomTypeId = $data['room_type_id'];
            $accommodationId = $data['accommodation_id'];    
            
            $roomType = DB::table('room_types')->where('id', $roomTypeId)->value('nombre');
            $accommodation = DB::table('accommodations')->where('id', $accommodationId)->value('nombre');

            if (!$roomType || !$accommodation) {
                $validator->errors()->add('accommodation_id', 'La combinación especificada no es válida.');
                return;
            }

            // Validar duplicado (excluyendo actual)
            $exists = DB::table('room_configurations')
                ->where('hotel_id', $hotelId)
                ->where('room_type_id', $roomTypeId)
                ->where('accommodation_id', $accommodationId)
                ->where('id', '!=', $RoomConfiguration->id)
                ->exists();

            if ($exists) {
                $validator->errors()->add('accommodation_id', 'Esta combinación ya existe para este hotel.');
                return;
            }

            // Validar suma de habitaciones
            $cantidadNueva = $data['cantidad'] ?? 0;
            $maxHabitaciones = DB::table('hotels')->where('id', $hotelId)->value('max_habitaciones');
            $cantidadAnterior = $RoomConfiguration->cantidad ?? 0;

            $sumaHabitaciones = DB::table('room_configurations')->where('hotel_id', $hotelId)->sum('cantidad');
            $total = ($sumaHabitaciones - $cantidadAnterior) + $cantidadNueva;

            if ($total > $maxHabitaciones) {
                $validator->errors()->add('cantidad', "La suma total de habitaciones excede el máximo permitido para el hotel.");
                return;
            }

            $this->validacionLogica($roomType, $accommodation, $validator);
        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $RoomConfiguration->update($data);
        return $RoomConfiguration;
    }

    public function delete($id)
    {
        $RoomConfiguration = RoomConfiguration::find($id);
        if (!$RoomConfiguration) {
            throw new \Exception('Habitación no encontrada');
        }

        $RoomConfiguration->delete();
    }

    private function validacionLogica($roomType, $accommodation, $validator)
    {
        // Validar combinación lógica
        $valid = [
            'Estándar' => ['Sencilla', 'Doble'],
            'Junior' => ['Triple', 'Cuádruple'],
            'Suite' => ['Sencilla', 'Doble', 'Triple'],
        ];

        if (!isset($valid[$roomType]) || !in_array($accommodation, $valid[$roomType])) {
            $validator->errors()->add('accommodation_id', "La acomodación '{$accommodation}' no es válida para el tipo '{$roomType}'.");
        }
    }
}