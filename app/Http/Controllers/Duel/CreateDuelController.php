<?php

namespace App\Http\Controllers\Duel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Duel\CreateGameRequest;
use App\Http\Resources\Duel\DuelResource;
use Game\Duel\CreateDuel;

class CreateDuelController extends Controller
{
    public function __invoke(CreateGameRequest $request, CreateDuel $createDuel): DuelResource
    {
        return DuelResource::make(
            $createDuel->handle($request->validated())
        );
    }
}
