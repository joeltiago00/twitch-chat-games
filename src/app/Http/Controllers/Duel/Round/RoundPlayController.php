<?php

namespace App\Http\Controllers\Duel\Round;

use App\Http\Controllers\Controller;
use App\Http\Resources\Duel\Round\RoundResult;
use Game\Duel\Round\PlayRound;

class RoundPlayController extends Controller
{
    public function __invoke(int $round, PlayRound $playRound): RoundResult
    {
        return RoundResult::make($playRound->handle($round)->toArray());
    }
}
