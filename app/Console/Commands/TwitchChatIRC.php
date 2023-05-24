<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TwitchIRC\TwitchChatClient;
use TwitchIRC\TwitchIRCService;

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
    public function handle()
    {
        $client = new TwitchIRCService('acostaleandro', 'oauth:cmkeivazk7eqcl6iy8o6d0uhzkx1ms');

        $client->connect();

        while (true) {
            $content =$client->read(512);

            $this->line($content);

            sleep(3);
        }

    }
}
