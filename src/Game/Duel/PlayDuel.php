<?php

namespace Game\Duel;

use App\Models\Duel;
use App\Models\Round;
use Game\Twitch\IRC\TwitchIRCService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class PlayDuel
{
    private array $nicks = [];
    private int $winPoints = 300;
    private int $minWinPoints = 50;
    private int $losePoints = 15;
    private int $maxLosePoints = 50;

    public function handle(Duel $duel, Round $round): Collection
    {

        $client = $this->getIRCService($duel->chat);

        $exp = now()->addSeconds($duel->duration_time - 3);

        $answerNumber = $round->answer_number;

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
            sprintf('%s_duel_%s_duel_answer_%s.json', now()->format('Y-m-d'), $duel->getKey(), $round->getKey()),
            json_encode($answers)
        );

        return collect($answers);
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

            $playerAnswer = $lineSeparated[$count - 1];

            $playerNick = $this->getNick($lineSeparated);

            if ($this->isValidAnswer($playerAnswer) && $this->notAnsweredByNick($playerNick)) {
                $playerAnswer = (int)str_replace('!', '', $playerAnswer);

                if ($this->isValidGuess($playerNick, $playerAnswer)) {
                    $isRightAnswer = $playerAnswer === $answerNumber;

                    $answers[] = [
                        'nick' => $playerNick,
                        'answer' => $playerAnswer,
                        'is_right_answer' => $isRightAnswer,
                        'win_points' => $isRightAnswer ? $this->winPoints : 0,
                        'lose_points' => $isRightAnswer ? 0 : $this->losePoints * -1,
                        'created_at' => now()->format('Y-m-d H:i:s.u')
                    ];

                    if (!$isRightAnswer) {
                        $this->setLosePoints();
                    }
                }

                $this->nicks[] = $playerNick;
            }

            $this->setWinPoints();
        }

        return $answers;
    }

    private function separateByLines(string $content): array
    {
        return explode(PHP_EOL, $content);
    }

    private function setWinPoints(): void
    {
        if ($this->winPoints < $this->minWinPoints) {
            $this->winPoints--;
        }
    }

    private function setLosePoints(): void
    {
        if ($this->losePoints > $this->maxLosePoints) {
            $this->losePoints++;
        }
    }

    private function notAnsweredByNick(string $playerNick): bool
    {
        return !in_array($playerNick, $this->nicks);
    }

    private function isValidAnswer(string $playerAnswer): int|false
    {
        return preg_match("/![1-6]/", $playerAnswer);
    }

    private function isValidGuess(string $playerNick, int $playerAnswer): bool
    {
        return !empty($playerNick) && !empty($playerAnswer);
    }
}
