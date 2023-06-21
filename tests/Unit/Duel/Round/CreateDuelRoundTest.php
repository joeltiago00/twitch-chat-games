<?php

namespace Tests\Unit\Duel\Round;

use App\Models\Answer;
use App\Models\Duel;
use App\Models\DuelAnswer;
use Game\Answer\RandomAnswer;
use Game\Duel\Round\CreateNewRound;
use Mockery;
use Repositories\Duel\DuelRepository;
use Repositories\DuelAnswer\DuelAnswerRepository;
use Tests\TestCase;

class CreateDuelRoundTest extends TestCase
{
    public function testSuccess()
    {
        $duelRepositoryMock = Mockery::mock(DuelRepository::class);
        $duelAnswerRepository = Mockery::mock(DuelAnswerRepository::class);
        $randomAnswerMock = Mockery::mock(RandomAnswer::class);

        $duelRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn(Duel::factory()->make(['id' => 1]));

        $randomAnswerMock->shouldReceive('handle')
            ->once()
            ->with(1, 1)
            ->andReturn(Answer::factory()->make(['id' => 1]));

        $duelAnswerRepository->shouldReceive('store')
            ->once()
            ->andReturn(DuelAnswer::factory()->make());

        $action = new CreateNewRound($duelRepositoryMock, $duelAnswerRepository, $randomAnswerMock);

        $action->handle(1);
    }
}
