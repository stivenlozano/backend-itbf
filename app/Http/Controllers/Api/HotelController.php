<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Models\Hotel;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Services\HotelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;


class HotelController extends Controller 
{
    protected $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index()
    {
        try {
            $hoteles = $this->hotelService->getAll();
            return response()->json(['results' => $hoteles, 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor', 'status' => 500], 500);
        }
    }

    public function show($id)
    {
        try {
            $hotel = $this->hotelService->getById($id);
            if (!$hotel) {
                return response()->json(['message' => 'Hotel no encontrado', 'status' => 404], 404);
            }
            return response()->json(['results' => $hotel, 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor', 'status' => 500], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $hotel = $this->hotelService->create($request->all());
            return response()->json(['results' => $hotel, 'status' => 201], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $e->errors(),
                'status' => 400
            ], 400);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor', 'status' => 500], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $hotel = $this->hotelService->update($id, $request->all());
            return response()->json(['message' => 'Hotel actualizado', 'hotel' => $hotel, 'status' => 200], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $e->errors(),
                'status' => 400
            ], 400);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 404], 404);
            // return response()->json(['message' => 'Error al actualizar hotel', 'status' => 500], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->hotelService->delete($id);
            return response()->json(['message' => 'Hotel eliminado', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 404], 404);
        }
    }
}