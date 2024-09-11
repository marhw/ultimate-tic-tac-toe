<?php

namespace App\Modules\Games\Domain\Shared;

abstract class Piece
{
    protected function __construct(protected string $piece)
    {
    }

    public function piece(): string
    {
        return $this->piece;
    }

    public function equals(Piece $piece): bool
    {
        return $this->piece === $piece->piece;
    }
}
