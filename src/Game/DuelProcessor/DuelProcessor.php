<?php

namespace Game\DuelProcessor;

use App\Models\Duel;
use App\Models\Round;
use Game\TwitchIRC\TwitchIRCService;
use Illuminate\Support\Facades\Storage;

class DuelProcessor
{
    private array $nicks = [];
    private int $winPoints = 300;

    public function play(Duel $duel, Round $duelAnswer): void
    {
        $client = $this->getIRCService($duel->chat);

        $exp = now()->addSeconds(10);

        $rightAnswer = $duelAnswer->answer_number;

        $content = [];

        while (true) {
            if ($exp->lessThanOrEqualTo(now())) {
                $client->close();;

                break;
            }

            $content[] = $client->read(512);
        }

        $answers = $this->processContent($content, $rightAnswer);

        // TODO:: analise how to store this info (db or file)
        Storage::put(
            sprintf('%s_duel_%s_duel_answer_%s.json', now()->format('Y-m-d'), $duel->getKey(), $duelAnswer->getKey()),
            json_encode(array_filter($answers))
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

    private function processContent(array $contents, int $rightAnswer): array
    {
        $answers = [];

        foreach ($contents as $content) {
            $linesSeparated = $this->separateByLines($content);

            $answers[] = array_merge($this->processAnswers($linesSeparated, $rightAnswer), $answers);
        }

        return $answers;
    }

    private function processAnswers(array $lines, int $rightAnswer): array
    {
        $answers = [];

        foreach ($lines as $line) {
            $lineSeparated = explode(':', $line);

            $count = count($lineSeparated);

            $playerAnswer = $lineSeparated[$count - 1];

            $playerNick = $this->getNick($lineSeparated);

            $answers[] = $this->prepareAnswer($playerAnswer, $rightAnswer, $playerNick);

            $this->winPoints--;
        }

        return $answers;
    }

    private function prepareAnswer(string $playerAnswer, int $rightAnswer, string $playerNick): array
    {
        if ($this->isValidAnswer($playerAnswer)) {
            $playerAnswer = (int)str_replace('!', '', $playerAnswer);

            $isRightAnswer = $playerAnswer === $rightAnswer;

            $answer = $this->checkAnswer($playerNick, $playerAnswer, $isRightAnswer);

            $this->nicks[] = $playerNick;
        }

        return $answer ?? [];
    }

    private function checkAnswer(string $playerNick, int $playerAnswer, bool $isRightAnswer): array
    {
        if ($this->isValidGuess($playerNick, $playerAnswer)) {
            $answer = [
                'nick' => $playerNick,
                'answer' => $playerAnswer,
                'is_right_answer' => $isRightAnswer,
                'win_points' => $isRightAnswer ? $this->winPoints : 0,
                'created_at' => now()->format('Y-m-d H:i:s.u')
            ];
        }

        return $answer ?? [];
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
