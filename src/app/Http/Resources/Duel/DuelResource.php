<?php

namespace App\Http\Resources\Duel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DuelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $type = $this->type;

        return [
            'id' => $this->getKey(),
            'chat' => $this->chat,
            'duration_time' => $this->duration_time,
            'finished_at' => $this->finished_at,
            'duel_type_id' => $type->id,
            'duel_type_name' => $type->name,
        ];
    }
}
