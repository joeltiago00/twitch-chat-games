<?php

namespace App\Http\Resources\Duel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DuelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $duelType = $this->duelType;

        return [
            'id' => $this->getKey(),
            'chat' => $this->chat,
            'duel_type_id' => $duelType->id,
            'duel_type_name' => $duelType->name,
        ];
    }
}
