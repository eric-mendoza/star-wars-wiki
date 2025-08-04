<?php

namespace App\Services;

use App\Http\Responses\PaginatedResponse;
use Illuminate\Http\JsonResponse;
use App\Repositories\SwapiRepository;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Expr\Array_;


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
                'movies' => $this->findPersonMovies($id),
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

            // Resolve characters names
            $characterUrls = $properties['characters'] ?? [];
            $characterIds = array_map(function ($url) {
                return basename($url);
            }, $characterUrls);

            // Fetch and transform character data
            $characters = collect($characterIds)->map(function ($characterId) {
                $characterResponse = app(self::class)->getPeopleById($characterId);
                $characterData = $characterResponse->getData(true);
                return $characterData['message'] ?? null ? null : $characterData;
            })->filter()->values()->all();

            return [
                'id' => $movie['uid'],
                'title' => $properties['title'],
                'opening_crawl' => $properties['opening_crawl'],
                'characters' => $characters,
            ];
        });

        if (is_null($data)) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json($data);
    }


    /**
     * This helper function was added to find in which movies a character shows up. The SWAPI API is not returning the
     * films even though the extended=true flag was passed. This endpoints searches for a specific character in all the
     * movies and caches the result.
     * @param $id person id
     * @return Array movies
    */
    public function findPersonMovies($id): array
    {
        $cacheKey = "person:$id:movies";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            $moviesResponse = $this->swapiRepository->getAllMovies();
            $movies = $moviesResponse['result'] ?? [];

            $matchedMovies = [];

            foreach ($movies as $movie) {
                $properties = $movie['properties'];
                $characterUrls = $properties['characters'] ?? [];

                foreach ($characterUrls as $url) {
                    if (basename($url) == $id) {
                        $matchedMovies[] = [
                            'id' => $movie['uid'],
                            'title' => $properties['title'],
                        ];
                        break;
                    }
                }
            }

            return $matchedMovies;
        });
    }

}
