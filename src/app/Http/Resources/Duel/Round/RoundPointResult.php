<?php

namespace App\Http\Resources\Duel\Round;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoundPointResult extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'nick' => $this['nick'],
            'points' => !$this['is_right_answer'] ? $this['lose_points'] : $this['win_points'],
            'is_right' => $this['is_right_answer']
        ];
    }
}
