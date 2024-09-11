<?php

namespace App\Modules\Games\Domain\Shared;

final class BoardSize
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        if ($x < 0 || $y < 0) {
            // #TODO: better error
            throw new \InvalidArgumentException('Board size must be greater than 0');
        }

        $this->x = $x;
        $this->y = $y;
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }
}
