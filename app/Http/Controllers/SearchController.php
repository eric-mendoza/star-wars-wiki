<?php

namespace App\Http\Controllers;

use App\Services\SwapiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(private SwapiService $swapiService) {}

    public function search(Request $request): JsonResponse
    {
        // Validate query params
        $validated = $request->validate([
            'term' => 'required|string',
            'type' => 'required|string|in:MOVIES,PEOPLE',
        ]);

        return $this->swapiService->search($validated['type'], $validated['term']);
    }
}
