<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AccommodationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class AccommodationController extends Controller 
{
    protected $accommodationService;

    public function __construct(AccommodationService $accommodationService)
    {
        $this->accommodationService = $accommodationService;
    }

    public function index()
    {
        try {
            $accommodations = $this->accommodationService->getAll();
            return response()->json(['results' => $accommodations, 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor', 'status' => 500], 500);
        }
    }
}