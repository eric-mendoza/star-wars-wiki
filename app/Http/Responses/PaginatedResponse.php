<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class PaginatedResponse
{
    protected array $data;
    protected array $metadata;

    public function __construct(array $data, int $total, int $currentPage, int $pageSize)
    {
        $this->data = $data;
        $this->metadata = [
            'total' => $total,
            'current_page' => $currentPage,
            'pages' => $pageSize != 0 ? (int) ceil($total / $pageSize) : 0,
            'page_size' => $pageSize,
        ];
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'metadata' => $this->metadata,
        ];
    }

    public function toResponse(): JsonResponse
    {
        return response()->json($this->toArray());
    }
}
