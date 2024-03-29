<?php

namespace App\Http\Resources\Duel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DuelRoundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'duel' => DuelResource::make($this->duel),
            'round' => RoundResource::make($this)
        ];
    }
}
