<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller 
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index($id)
    {
        try {
            $habitaciones = $this->roomService->getAll($id);
            return response()->json(['results' => $habitaciones, 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor', 'status' => 500], 500);
        }
    }

    public function show($id)
    {
        try{
            $habitacion = $this->roomService->getById($id);       
            return response()->json(['results' => $habitacion, 'status' => 200], 200);

        }catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor', 'status' => 500], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $habitacion = $this->roomService->create($request->all());
            return response()->json(['results' => $habitacion, 'status' => 201], 201);

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
            $habitacion = $this->roomService->update($id, $request->all());
            return response()->json(['message' => 'Habitación actualizada', 'data' => $habitacion, 'status' => 200], 200);

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

    public function destroy($id)
    {
        try {
            $this->roomService->delete($id);
            return response()->json(['message' => 'Habitación eliminada', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor', 'status' => 500], 500);
        }
    }
}