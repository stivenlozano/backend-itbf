<?php

namespace App\Services;

use App\Models\Hotel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class HotelService
{
    public function getAll()
    {
        return Hotel::all();
    }

    public function getById($id)
    {
        return Hotel::find($id);
    }

    public function create(array $data)
    {
        $rules = [
            'nombre' => ['required', Rule::unique('hotels')],
            'direccion' => 'required',
            'ciudad' => 'required',
            'nit' => ['required', Rule::unique('hotels')],
            'max_habitaciones' => 'required'
        ];

        $messages = [
            'nombre' => 'Ya existe un registro con ese nombre',
            'direccion' => 'La dirección es requerida',
            'ciudad' => 'La ciudad es requerida',
            'nit' => 'Ya existe un registro con ese nit',
            'max_habitaciones' => 'La cantidad de habitaciones es requerida'
        ];

        $this->validateData($data, $rules, $messages);
        return Hotel::create($data);
    }

    public function update($id, array $data)
    {
        $hotel = $this->getById($id);
        if (!$hotel) {
            throw new \Exception('Hotel no encontrado');
        }

        $rules = [
            'nombre' => ['required', Rule::unique('hotels')->ignore($id, 'id')],
            'direccion' => 'required',
            'ciudad' => 'required',
            'nit' => ['required', Rule::unique('hotels')->ignore($id, 'id')],
            'max_habitaciones' => 'required'
        ];

        $messages = [
            'nombre' => 'Ya existe un registro con ese nombre',
            'direccion' => 'La dirección es requerida',
            'ciudad' => 'La ciudad es requerida',
            'nit' => 'Ya existe un registro con ese nit',
            'max_habitaciones' => 'La cantidad de habitaciones es requerida'
        ];

        $this->validateData($data, $rules, $messages);
        $hotel->update($data);
        return $hotel;
    }

    public function delete($id)
    {
        $hotel = $this->getById($id);
        if (!$hotel) {
            throw new \Exception('Hotel no encontrado');
        }

        $hotel->delete();
    }

    private function validateData(array $data, $rules, $messages)
    {
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}