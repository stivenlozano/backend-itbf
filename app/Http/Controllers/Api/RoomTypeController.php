<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RoomTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class RoomTypeController extends Controller 
{
    protected $roomTypeService;

    public function __construct(RoomTypeService $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;
    }

    public function index()
    {
        try{
            $hoteles = $this->roomTypeService->getAll();
            return response()->json(['results' => $hoteles, 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor', 'status' => 500], 500);
        }
    }
}