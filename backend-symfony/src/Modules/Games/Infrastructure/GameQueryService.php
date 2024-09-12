<?php

namespace App\Modules\Games\Infrastructure;

use App\Modules\Games\Application\GameQueryService as IGameQueryService;
use App\Modules\Games\Application\Response\GameResponse;
use App\Modules\Games\Infrastructure\Doctrine\Documents\BoardDocument;
use App\Modules\Games\Infrastructure\Doctrine\Documents\ScoreDocument;
use App\Modules\Games\Infrastructure\Doctrine\MongoGameRepository;
use Doctrine\Common\Collections\ArrayCollection;

class GameQueryService implements IGameQueryService
{
    public function __construct(private readonly MongoGameRepository $gameRepository)
    {
    }

    public function getCurrentGameState(): GameResponse | null
    {
        $doc = $this->gameRepository->findRawTicTacToeGame();

        if (!$doc) {
            return null;
        }


        $board = $this->mapBoardToGameResponse($doc->getBoard());
        $score = $this->mapScoreToGameResponse($doc->getScore());

        return new GameResponse(
            $board,
            $score,
            $doc->getNextPlayer(),
            $doc->getWinner() ?? ""
        );
    }

    /**
     * @return array<array<string>>
     */
    private function mapBoardToGameResponse(BoardDocument $boardDocument): array
    {
        $board = [];

        for ($x = 0; $x < $boardDocument->getSizeX(); $x++) {
            for ($y = 0; $y < $boardDocument->getSizeY(); $y++) {
                $board[$x][$y] = "";
            }
        }

        foreach ($boardDocument->getElements() as $element) {
            $board[$element->getX()][$element->getY()] = $element->getPiece();
        }

        return $board;
    }

    /**
     * @param ArrayCollection<int, ScoreDocument> $scores
     * @return array<string, int>
     */
    private function mapScoreToGameResponse(ArrayCollection $scores): array
    {
        $flatScores = [];

        foreach ($scores->toArray() as $score) {
            $flatScores[$score->getPlayer()] = $score->getScore();
        }

        return $flatScores;
    }
}
