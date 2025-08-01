<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function getById($id): JsonResponse
    {
        return response()->json(
            "people with id " . $id,
        );
    }
}
