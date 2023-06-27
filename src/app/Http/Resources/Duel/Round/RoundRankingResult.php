<?php

namespace App\Http\Resources\Duel\Round;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoundRankingResult extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'nick' => $this['nick'],
            'total_points' => 0
        ];
    }
}
