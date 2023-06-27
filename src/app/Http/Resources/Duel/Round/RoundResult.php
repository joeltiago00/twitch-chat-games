<?php

namespace App\Http\Resources\Duel\Round;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoundResult extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ranking' => RoundRankingResult::collection($this['ranking']),
            'round_score' => RoundPointResult::collection($this['round_score'])
        ];
    }
}
