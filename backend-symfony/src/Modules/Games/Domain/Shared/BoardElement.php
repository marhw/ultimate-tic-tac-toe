<?php

namespace App\Modules\Games\Domain\Shared;

/**
 * @template TPiece of Piece
 */
final class BoardElement
{
    private int $x;
    private int $y;
    /** @var TPiece */
    private $piece;

    /**
     * @param TPiece $piece
     */
    public function __construct(int $x, int $y, $piece)
    {
        $this->x = $x;
        $this->y = $y;
        $this->piece = $piece;
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function piece(): Piece
    {
        return $this->piece;
    }
}
