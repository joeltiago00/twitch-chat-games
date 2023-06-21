<?php

namespace Game\MusicDuel;

use App\Models\Duel;
use App\Models\DuelAnswer;
use Game\TwitchIRC\TwitchIRCService;
use Illuminate\Support\Facades\Storage;

class MusicDuel
{
    private array $nicks = [];
    private int $winPoints = 300;

    public function play(Duel $duel, DuelAnswer $duelAnswer): void
    {
        $client = $this->getIRCService($duel->chat);

        $exp = now()->addSeconds(15);

        $answerNumber = $duelAnswer->answer_number;

        $content = [];

        while (true) {
            if ($exp->lessThanOrEqualTo(now())) {
                $client->close();;

                break;
            }

            $content[] = $client->read(512);
        }

        $answers = $this->processContent($content, $answerNumber);

        // TODO:: analise how to store this info (db or file)
        Storage::put(
            sprintf('%s_duel_%s_duel_answer_%s.json', now()->format('Y-m-d'), $duel->getKey(), $duelAnswer->getKey()),
            json_encode($answers)
        );
    }

    private function getIRCService(string $chat): TwitchIRCService
    {
        $client = new TwitchIRCService($chat, config('twitch.irc-oauth-token'));

        $client->connect();

        return $client;
    }

    private function getNick($lineSeparated): string
    {
        return explode('!', $lineSeparated[1] ?? '')[0];
    }

    private function processContent(array $contents, int $answerNumber): array
    {
        $answers = [];

        foreach ($contents as $content) {
            $linesSeparated = $this->separateByLines($content);

            $answers = array_merge($this->processAnswers($linesSeparated, $answerNumber), $answers);
        }

        return $answers;
    }

    private function processAnswers(array $lines, int $answerNumber): array
    {
        $answers = [];

        foreach ($lines as $line) {
            $lineSeparated = explode(':', $line);

            $count = count($lineSeparated);

            $answer = $lineSeparated[$count - 1];

            $nick = $this->getNick($lineSeparated);

            if ($this->isValidAnswer($answer)) {
                $answer = (int)str_replace('!', '', $answer);

                if ($this->isValidGuess($nick, $answer)) {
                    $answers[] = [
                        'nick' => $nick,
                        'answer' => $answer,
                        'win_points' => $answer === $answerNumber ? $this->winPoints : 0,
                        'created_at' => now()->format('Y-m-d H:i:s.u')
                        ];
                }

                $this->nicks[] = $nick;
            }

            $this->winPoints--;
        }

        return $answers;
    }

    private function separateByLines(string $content): array
    {
        return explode(PHP_EOL, $content);
    }

    private function alreadyAnsweredByNick(string $nick): bool
    {
        return !in_array($nick, $this->nicks);
    }

    private function isValidAnswer(string $answer): int|false
    {
        return preg_match("/![1-6]/", $answer);
    }

    private function isValidGuess(string $nick, int $answer): bool
    {
        return !empty($nick) && !empty($answer);
    }
}
