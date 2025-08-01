<?php

namespace App\Services;

use App\Http\Responses\PaginatedResponse;
use Illuminate\Http\JsonResponse;
use App\Repositories\SwapiRepository;


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
}
