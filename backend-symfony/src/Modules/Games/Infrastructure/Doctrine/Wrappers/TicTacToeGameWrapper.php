<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Wrappers;

use App\Modules\Games\Domain\TicTacToe\TicTacToeGame;
use App\Modules\Games\Infrastructure\Doctrine\Documents\TicTacToeGameDocument;
use App\Modules\Games\Infrastructure\Doctrine\Mappers\TicTacToeGameMapper;

class TicTacToeGameWrapper extends TicTacToeGame
{
    public function __construct(private readonly TicTacToeGameDocument $doc)
    {
        parent::__construct();

        $this->nextPlayer = TicTacToeGameMapper::stringToPiece($doc->getNextPlayer());
        $winner = $doc->getWinner();
        $this->winner = $winner !== null ? TicTacToeGameMapper::stringToPiece($winner) : null;
        $this->board = TicTacToeGameMapper::mapDocumentToBoard($doc->getBoard());
        $this->score = TicTacToeGameMapper::mapDocumentsToScore($doc->getScore());
    }

    public function applyChangesAndGetDoc(): TicTacToeGameDocument
    {
        $this->doc->setBoard(TicTacToeGameMapper::mapBoardToDocument($this->board));
        $this->doc->setNextPlayer($this->nextPlayer->symbol());
        $this->doc->setWinner($this->winner?->symbol());
        $this->doc->setScore(TicTacToeGameMapper::mapScoreToDocuments($this->score));

        return $this->doc;
    }
}
