<?php

namespace App\Services;

use App\Http\Responses\PaginatedResponse;
use Illuminate\Http\JsonResponse;
use App\Repositories\SwapiRepository;
use Illuminate\Support\Facades\Cache;


class SwapiService extends Service
{

    public const PEOPLE_TYPE = 'PEOPLE';
    public const MOVIES_TYPE = 'MOVIES';
    public function __construct(private SwapiRepository $swapiRepository) {}

    public function search(string $type, string $term): JsonResponse {
        // Get data depending on type
        $raw = match ($type) {
            self::PEOPLE_TYPE => $this->swapiRepository->searchPeopleByName($term),
            self::MOVIES_TYPE => $this->swapiRepository->searchMovieByTitle($term),
            default => [],
        };

        // Transform data
        $data = $raw['result'] ?? $raw['results'] ?? [];
        $transformedData = array_map(function ($item) use($type) {
            $properties = $item['properties'];
            return [
                'id' => $item['uid'] ?? null,
                'name' => $properties['title'] ?? $properties['name'] ?? null,
                'type' => $type,
            ];
        }, $data);

        // Prepare response
        $total = $raw['total_records'] ?? count($data);
        $pageSize = count($data);
        $response = new PaginatedResponse(
            $transformedData,
            $total,
            1,
            $pageSize
        );
        return $response->toResponse();
    }

    public function getPeopleById($id): JsonResponse
    {
        $cacheKey = "person:$id";

        $data = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            $response = $this->swapiRepository->getPeopleById($id);
            $person = $response['result'] ?? null;

            if (is_null($person)) {
                return null;
            }

            $properties = $person['properties'];

            return [
                'id' => $person['uid'],
                'name' => $properties['name'],
                'birth_year' => $properties['birth_year'] ?? null,
                'gender' => $properties['gender'] ?? null,
                'eye_color' => $properties['eye_color'] ?? null,
                'hair_color' => $properties['hair_color'] ?? null,
                'height' => $properties['height'] ?? null,
                'mass' => $properties['mass'] ?? null,
                'movies' => $properties['films'] ?? [],
            ];
        });

        if (is_null($data)) {
            return response()->json(['message' => 'Person not found'], 404);
        }

        return response()->json($data);
    }

    public function getMovieById($id): JsonResponse
    {
        $cacheKey = "movie:$id";

        $data = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            $response = $this->swapiRepository->getMovieById($id);
            $movie = $response['result'] ?? null;

            if (is_null($movie)) {
                return null;
            }

            $properties = $movie['properties'];

            return [
                'id' => $movie['uid'],
                'title' => $properties['title'],
                'opening_crawl' => $properties['opening_crawl'],
                'characters' => $properties['characters'] ?? [],
            ];
        });

        if (is_null($data)) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json($data);
    }
}
