<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function getById($id): JsonResponse
    {
        return response()->json(
            "movie with id " . $id,
        );
    }
}
