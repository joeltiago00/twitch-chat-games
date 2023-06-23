<?php

namespace App\Console\Commands;

use Game\Auth\Twitch\LoginWithTwitch;
use Game\Twitch\API\Request\Client\TwitchApiClient;
use Illuminate\Console\Command;

class TwitchTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ttest';

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
        $client = new TwitchApiClient(config('twitch.api.client_id'), config('twitch.api.client_secret'));

        dd($client->get('helix/users'));

        $auth = new LoginWithTwitch();

        $auth->handle('');
    }
}
