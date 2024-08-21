<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KaryawanCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nomor_induk' => $item->nomor_induk,
                    'nama' => $item->nama,
                    'alamat' => $item->alamat,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'tanggal_bergabung' => $item->tanggal_bergabung,
                ];
            }),
            'pagination' => [
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
            ],
        ];
    }
}
