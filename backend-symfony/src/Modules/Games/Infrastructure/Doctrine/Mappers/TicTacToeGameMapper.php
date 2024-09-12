<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Mappers;

use App\Modules\Games\Domain\Shared\BoardElement;
use App\Modules\Games\Domain\Shared\Errors\InvalidPiece;
use App\Modules\Games\Domain\TicTacToe\TicTacToeBoard;
use App\Modules\Games\Domain\TicTacToe\TicTacToeGame;
use App\Modules\Games\Domain\TicTacToe\TicTacToePiece;
use App\Modules\Games\Domain\TicTacToe\TicTacToeScore;
use App\Modules\Games\Infrastructure\Doctrine\Documents\BoardDocument;
use App\Modules\Games\Infrastructure\Doctrine\Documents\BoardElementDocument;
use App\Modules\Games\Infrastructure\Doctrine\Documents\ScoreDocument;
use App\Modules\Games\Infrastructure\Doctrine\Documents\TicTacToeGameDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Error;
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

        /** @var TicTacToeScore $score */
        $score = $reflection->getProperty('score')->getValue($ticTacToeGame);
        $document->setScore(self::mapScoreToDocuments($score));

        return $document;
    }

    public static function mapBoardToDocument(TicTacToeBoard $board): BoardDocument
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
    public static function mapScoreToDocuments(TicTacToeScore $score): array
    {
        $currentScore = $score->getCurrentScore();

        /** @var array<ScoreDocument> $documents */
        $documents = [];

        foreach ($currentScore as $player => $scoreValue) {
            $document = new ScoreDocument();
            $document->setPlayer($player);
            $document->setScore($scoreValue);

            $documents[] = $document;
        }

        return $documents;
    }

    public static function mapDocumentToBoard(BoardDocument $boardDocument): TicTacToeBoard
    {
        $elements = [];

        foreach ($boardDocument->getElements() as $element) {
            $elements[] = new BoardElement(
                $element->getX(),
                $element->getY(),
                self::stringToPiece($element->getPiece())
            );
        }

        return new TicTacToeBoard($elements);
    }

    public static function stringToPiece(string $string): TicTacToePiece
    {
        $result = TicTacToePiece::fromString($string);
        if ($result instanceof InvalidPiece) {
            //#TODO: better error
            throw new Error("implementation error");
        }

        return $result;
    }

    /**
     * @param ArrayCollection<int, ScoreDocument> $scoreDocuments
     */
    public static function mapDocumentsToScore(ArrayCollection $scoreDocuments): TicTacToeScore
    {
        $score = new TicTacToeScore();

        foreach ($scoreDocuments->toArray() as $scoreDocument) {
            $score->addScoreForPlayer(
                self::stringToPiece($scoreDocument->getPlayer()),
                $scoreDocument->getScore()
            );
        }

        return $score;
    }
}
