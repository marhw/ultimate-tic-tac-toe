<?php

namespace App\Modules\Games\Domain\Shared;

use App\Modules\Games\Domain\Shared\Errors\PositionIsOutOfBoardBound;

final class BoardPosition
{
    private int $x;
    private int $y;

    protected function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public static function create(int $x, int $y, BoardSize $size): self | PositionIsOutOfBoardBound
    {
        if ($x >= $size->x() || $y >= $size->y()) {
            return new PositionIsOutOfBoardBound();
        }

        return new self($x, $y);
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
