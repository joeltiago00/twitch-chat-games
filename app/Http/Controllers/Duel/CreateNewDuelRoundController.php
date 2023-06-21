<?php

namespace App\Http\Controllers\Duel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Duel\DuelRoundResource;
use Game\Duel\Round\CreateNewRound;

class CreateNewDuelRoundController extends Controller
{
    public function __invoke(int $duel, CreateNewRound $createNewRound): DuelRoundResource
    {
        return DuelRoundResource::make(
            $createNewRound->handle($duel)
        );
    }
}
