<?php

namespace Tests\Unit\Duel;


use App\Models\Duel;
use Exception;
use Game\Duel\CreateDuel;
use Mockery;
use PHPUnit\Framework\TestCase;
use Repositories\Duel\DuelRepository;

class CreateDuelTest extends TestCase
{
    public function testSuccess()
    {
        $duelEloquentRepository = Mockery::mock(DuelRepository::class);

        $duelEloquentRepository->shouldReceive('store')
            ->once()
            ->andReturn(Duel::factory()->make(['chat' => 'test']));

        $action = new CreateDuel($duelEloquentRepository);

        $duel = $action->handle(['chat' => 'test', 'duel_type_id' => 1]);

        $this->assertEquals('test', $duel->chat);
    }

    public function testFailDuelNotCreated()
    {
        $this->expectException(Exception::class);

        $duelEloquentRepository = Mockery::mock(DuelRepository::class);

        $duelEloquentRepository->shouldReceive('store')
            ->once()
            ->andThrows(Exception::class);

        $action = new CreateDuel($duelEloquentRepository);

        $action->handle(['chat' => 'test']);

    }

    public function testFailInvalidPayload()
    {
        $this->expectException(Exception::class);

        $action = new CreateDuel(app(DuelRepository::class));

        $action->handle([]);
    }
}
