<?php

namespace App\Modules\Games\Application\Response;

final class GameResponse
{
    /**
     * @param array<array<string>> $board
     * @param array<string, int> $score
     */
    public function __construct(
        public readonly array $board,
        public readonly array $score,
        public readonly string $currentTurn,
        public readonly string $victory,
    ) {
    }
}
