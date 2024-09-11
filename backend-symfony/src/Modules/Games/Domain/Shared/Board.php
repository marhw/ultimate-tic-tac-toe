<?php

namespace App\Modules\Games\Domain\Shared;

/**
 * @template TPiece of Piece
 */
abstract class Board
{
    /**
     * @param array<TPiece> $pieces
     */
    public function __construct(protected readonly BoardSize $size, private array $pieces = [])
    {
    }

    /**
     * @return array<TPiece> $pieces
     */
    public function getRow(int $row): array
    {
        return array_filter($this->pieces, fn($piece) => $piece->position()->y() === $row);
    }

    /**
     * @return array<array<TPiece>> $pieces
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
     * @return array<array<TPiece>> $pieces
     */
    public function getColumns(): array
    {
        $columns = [];
        for ($i = 0; $i < $this->size->x(); $i++) {
            $columns[] = $this->getColumn($i);
        }

        return $columns;
    }

    public function getColumn(int $column): array
    {
        return array_filter($this->pieces, fn($piece) => $piece->position()->x() === $column);
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

        $this->pieces[$index] = $piece;
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

    /**
     * @return TPiece|null
     */
    public function getPieceAt(BoardPosition $position)
    {
        $index = $this->positionToBoardIndex($position);
        return $this->getPieceByIndex($index);
    }

    public function clear(): void
    {
        $this->pieces = [];
    }

    public function reset(): void
    {
        $this->pieces = [];
    }


    protected function positionToBoardIndex(BoardPosition $position): int
    {
        return $position->x() * $position->y() + $position->x();
    }

    protected function coordsToBoardIndex(int $x, int $y): int
    {
        return $x * $y + $x;
    }

    /**
     * @return TPiece|null
     */
    protected function getPieceByIndex(int $index)
    {
        return $this->pieces[$index] ?? null;
    }
}
