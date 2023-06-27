<?php

namespace App\Console\Commands;

use App\Models\Duel;
use App\Models\Round;
use Game\Duel\PlayDuel;
use Illuminate\Console\Command;

class TwitchChatIRC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:twitch-chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(PlayDuel $duelProcessor)
    {
//        //acostaleandro loud_coringa
        $duelProcessor->handle(Duel::factory()->make(['chat' => 'alvez2g', 'id' => 1]), Round::factory()->make(['id' => 1, 'answer_number' => 1]));
    }

}
