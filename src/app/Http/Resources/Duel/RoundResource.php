<?php

namespace App\Http\Resources\Duel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'answer_id' => $this->answer_id,
            'options' => $this->options,
            'created_at' => $this->created_at
        ];
    }
}
