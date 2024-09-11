<?php

namespace App\Modules\Games\Domain\Shared;

/**
 * @template TPiece of Piece
 */
abstract class Board
{
    /**
     * @param array<BoardElement<TPiece>> $pieces
     */
    public function __construct(protected readonly BoardSize $size, private array $pieces = [])
    {
    }

    /**
     * @return array<array<BoardElement<TPiece>>>
     */
    public function getRows(): array
    {
        $rows = [];
        for ($i = 0; $i < $this->size->y(); $i++) {
            $rows[] = $this->getRow($i);
        }

        return $rows;
    }

    /**
     * @return array<BoardElement<TPiece>>
     */
    public function getRow(int $row): array
    {
        return array_filter($this->pieces, fn($piece) => $piece->y() === $row);
    }

    /**
     * @return array<array<BoardElement<TPiece>>>
     */
    public function getColumns(): array
    {
        $columns = [];
        for ($i = 0; $i < $this->size->x(); $i++) {
            $columns[] = $this->getColumn($i);
        }

        return $columns;
    }

    /**
     * @return array<BoardElement<TPiece>>
     */
    public function getColumn(int $column): array
    {
        return array_filter($this->pieces, fn($piece) => $piece->x() === $column);
    }

    /**
     * @param TPiece | null $piece
     */
    public function setPieceAt(BoardPosition $position, $piece): void
    {
        $index = $this->positionToBoardIndex($position);

        if ($piece === null) {
            unset($this->pieces[$index]);
            return;
        }

        $this->pieces[$index] = new BoardElement($position->x(), $position->y(), $piece);
    }

    protected function positionToBoardIndex(BoardPosition $position): int
    {
        return $position->x() * $position->y() + $position->x();
    }

    public function isPositionOccupied(BoardPosition $position): bool
    {
        $index = $this->positionToBoardIndex($position);
        return isset($this->pieces[$index]);
    }

    public function size(): BoardSize
    {
        return $this->size;
    }

    public function clear(): void
    {
        $this->pieces = [];
    }

    public function reset(): void
    {
        $this->pieces = [];
    }

    protected function coordsToBoardIndex(int $x, int $y): int
    {
        return $x * $y + $x;
    }

    /**
     * @return BoardElement<TPiece>|null
     */
    protected function getPieceByIndex(int $index): BoardElement | null
    {
        return $this->pieces[$index] ?? null;
    }
}
