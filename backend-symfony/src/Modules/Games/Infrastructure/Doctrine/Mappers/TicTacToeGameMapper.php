<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Mappers;

use App\Modules\Games\Domain\TicTacToe\TicTacToeBoard;
use App\Modules\Games\Domain\TicTacToe\TicTacToeGame;
use App\Modules\Games\Domain\TicTacToe\TicTacToePiece;
use App\Modules\Games\Domain\TicTacToe\TicTacToeScore;
use App\Modules\Games\Infrastructure\Doctrine\Documents\BoardDocument;
use App\Modules\Games\Infrastructure\Doctrine\Documents\BoardElementDocument;
use App\Modules\Games\Infrastructure\Doctrine\Documents\ScoreDocument;
use App\Modules\Games\Infrastructure\Doctrine\Documents\TicTacToeGameDocument;
use ReflectionClass;

class TicTacToeGameMapper
{
    public static function mapGameObjectToDocument(TicTacToeGame $ticTacToeGame): TicTacToeGameDocument
    {
        $document = new TicTacToeGameDocument();
        $reflection = new ReflectionClass($ticTacToeGame);

        /** @var TicTacToePiece $nextPlayer */
        $nextPlayer = $reflection->getProperty('nextPlayer')->getValue($ticTacToeGame);
        $document->setNextPlayer($nextPlayer->symbol());

        /** @var TicTacToePiece | null $winner */
        $winner = $reflection->getProperty('winner')->getValue($ticTacToeGame);
        $document->setWinner($winner?->symbol());

        /** @var TicTacToeBoard $board */
        $board = $reflection->getProperty('board')->getValue($ticTacToeGame);
        $document->setBoard(self::mapBoardToDocument($board));

        /** @var TicTacToeScore $board */
        $score = $reflection->getProperty('score')->getValue($ticTacToeGame);
        $document->setScore(self::mapScoreToDocuments($score));

        return $document;
    }

    /**
     * @param TicTacToeBoard $board
     */
    private static function mapBoardToDocument(TicTacToeBoard $board): BoardDocument
    {
        $boardDocument = new BoardDocument();
        $boardDocument->setSizeX($board->size()->x());
        $boardDocument->setSizeY($board->size()->y());

        $elements = $board->elements();

        /** @var array<BoardElementDocument> $documents */
        $documents = [];

        foreach ($elements as $element) {
            $document = new BoardElementDocument();
            $document->setX($element->x());
            $document->setY($element->y());
            $document->setPiece($element->piece()->symbol());

            $documents[] = $document;
        }

        $boardDocument->setElements($documents);


        return $boardDocument;
    }

    /**
     * @param TicTacToeScore $score
     * @return array<ScoreDocument>
     */
    private static function mapScoreToDocuments(TicTacToeScore $score): array
    {
        $currentScore = $score->getCurrentScore();

        /** @var array<ScoreDocument> $documents */
        $documents = [];

        foreach ($currentScore as $playerId => $scoreValue) {
            $document = new ScoreDocument();
            $document->setPlayerId($playerId);
            $document->setScore($scoreValue);

            $documents[] = $document;
        }

        return $documents;
    }
}
