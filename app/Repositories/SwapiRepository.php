<?php

namespace App\Repositories;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class SwapiRepository extends Repository
{
    public const BASE_URL = 'https://swapi.tech/api/';
    public const PEOPLE_PATH = 'people';
    public const MOVIE_PATH = 'films';
    public function searchPeopleByName(string $term): array {
        $response = Http::get(self::BASE_URL . '/' . self::PEOPLE_PATH, [
            'name' => $term
        ]);
        return $response->json();
    }

    public function searchMovieByTitle(string $term): array {
        $response = Http::get(self::BASE_URL . '/' . self::MOVIE_PATH, [
            'title' => $term
        ]);
        return $response->json();
    }

    public function getPeopleById(string $id): array {
        $response = Http::get(self::BASE_URL . '/' . self::PEOPLE_PATH . '/' . $id);
        return $response->json();
    }

    public function getMovieById(string $id): array {
        $response = Http::get(self::BASE_URL . '/' . self::MOVIE_PATH . '/' . $id);
        return $response->json();
    }

    public function getAllMovies(): array {
        $response = Http::get(self::BASE_URL . '/' . self::MOVIE_PATH);
        return $response->json();
    }
}
