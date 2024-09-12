<?php

namespace App\Modules\Games\Domain\Shared;

abstract class Piece
{
    protected function __construct(protected string $symbol)
    {
    }

    public function symbol(): string
    {
        return $this->symbol;
    }

    public function equals(Piece $piece): bool
    {
        return $this->symbol === $piece->symbol;
    }
}
