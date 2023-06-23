<?php

namespace App\Console\Commands;

use App\Models\Duel;
use App\Models\Round;
use Game\DuelProcessor\DuelProcessor;
use Game\TwitchIRC\TwitchIRCService;
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
    public function handle(DuelProcessor $duelProcessor)
    {
        //acostaleandro loud_coringa
        $duelProcessor->play(Duel::factory()->make(['chat' => 'alvez2g', 'id' => 1]), Round::factory()->make(['id' => 1, 'answer_number' => 1]));
//        $this->extracted();

    }

    /**
     * @return mixed
     */
    public function extracted()
    {
        $client = new TwitchIRCService('loud_coringa', 'oauth:cmkeivazk7eqcl6iy8o6d0uhzkx1ms');

        $client->connect();
        $i = 0;
        while (true) {
            $content = $client->read(512);

            $this->line($content);

            if ($i > 1) {
                $linesSeparated = explode(PHP_EOL, $content);

                foreach ($linesSeparated as $line) {
                    $lineSeparated = explode(':', $line);

                    $count = count($lineSeparated);

                    $answer = $lineSeparated[$count - 1];

                    $nick = explode('!', $lineSeparated[1])[0];

                    dd($answer, $nick);
                }

            }

//            sleep(3);

            $i++;
        }
    }
}
