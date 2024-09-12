<?php

namespace App\Modules\Games\Domain\Shared;

/**
 * @template TPiece of Piece
 */
abstract class Board
{
    /**
     * @var array<BoardElement<TPiece>> $elements
     */
    private array $elements = [];

    /**
     * @param array<BoardElement<TPiece>> $elements
     */
    public function __construct(protected readonly BoardSize $size, array $elements = [])
    {
        foreach ($elements as $element) {
            $this->elements[$this->coordsToBoardIndex($element->x(), $element->y())] = $element;
        }
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
        return array_filter($this->elements, fn($piece) => $piece->y() === $row);
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
        return array_filter($this->elements, fn($piece) => $piece->x() === $column);
    }

    /**
     * @param TPiece | null $piece
     */
    public function setPieceAt(BoardPosition $position, $piece): void
    {
        $index = $this->positionToBoardIndex($position);

        if ($piece === null) {
            unset($this->elements[$index]);
            return;
        }

        $this->elements[$index] = new BoardElement($position->x(), $position->y(), $piece);
    }

    protected function positionToBoardIndex(BoardPosition $position): int
    {
        return $this->size->y() * $position->y() + $position->x();
    }

    public function isPositionOccupied(BoardPosition $position): bool
    {
        $index = $this->positionToBoardIndex($position);
        return isset($this->elements[$index]);
    }

    public function size(): BoardSize
    {
        return $this->size;
    }

    public function clear(): void
    {
        $this->elements = [];
    }

    public function reset(): void
    {
        $this->elements = [];
    }

    /**
     * @return array<BoardElement<TPiece>>
     */
    public function elements(): array
    {
        return $this->elements;
    }

    protected function coordsToBoardIndex(int $x, int $y): int
    {
        return $this->size->y() * $y + $x;
    }

    /**
     * @return BoardElement<TPiece>|null
     */
    protected function getPieceByIndex(int $index): BoardElement | null
    {
        return $this->elements[$index] ?? null;
    }
}
