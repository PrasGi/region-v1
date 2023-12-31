<?php

namespace App\Http\Resources\Village;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VillageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $paginator = $this->resource;

        return [
            'data' => $this->collection,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'from' => $paginator->firstItem(),
                'last_page' => $paginator->lastPage(),
                'path' => $paginator->path(),
                'per_page' => $paginator->perPage(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
                'links' => $paginator->toArray()['links'], // Mengambil daftar tautan dari Paginator
            ]
        ];
    }
}
