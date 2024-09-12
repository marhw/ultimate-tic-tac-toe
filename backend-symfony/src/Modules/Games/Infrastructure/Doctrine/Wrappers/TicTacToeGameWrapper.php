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

        $this->board = TicTacToeGameMapper::mapDocumentToBoard($doc->getBoard());
        $this->score = TicTacToeGameMapper::mapDocumentsToScore($doc->getScore());
        $this->nextPlayer = TicTacToeGameMapper::stringToPiece($doc->getNextPlayer());
        $this->winner = TicTacToeGameMapper::nullableStringToPiece($doc->getWinner());
        $this->playerWhoStartedLastGame = TicTacToeGameMapper::nullableStringToPiece(
            $doc->getPlayerWhoStartedLastGame()
        );
    }

    public function applyChangesAndGetDoc(): TicTacToeGameDocument
    {
        $this->doc->setBoard(TicTacToeGameMapper::mapBoardToDocument($this->board));
        $this->doc->setScore(TicTacToeGameMapper::mapScoreToDocuments($this->score));
        $this->doc->setNextPlayer($this->nextPlayer->symbol());
        $this->doc->setWinner($this->winner?->symbol());
        $this->doc->setPlayerWhoStartedLastGame($this->playerWhoStartedLastGame?->symbol());

        return $this->doc;
    }
}
