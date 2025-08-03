<?php

namespace App\Http\Controllers;

use App\Services\SwapiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(private SwapiService $swapiService) {}
    public function getById($id): JsonResponse
    {
        return $this->swapiService->getMovieById($id);
    }
}
