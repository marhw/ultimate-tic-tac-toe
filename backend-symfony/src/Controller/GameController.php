<?php

namespace App\Controller;

use App\Controller\DTO\MakeMoveDTO;
use App\Modules\Games\Application\Response\GameNotStartedYet;
use App\Modules\Games\Application\Response\PiecePlacedOutOfTurn;
use App\Modules\Games\Application\Response\PositionInBoardAlreadyTaken;
use App\Modules\Games\GamesModule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    public function __construct(private readonly GamesModule $gamesModule)
    {
    }

    #[Route(path: '/', name: 'start-game', methods: [Request::METHOD_GET], format: 'json')]
    public function startGame(): JsonResponse
    {
        $this->gamesModule->startGame();

        return $this->getCurrentGameState();
    }

    #[Route(path: '/move', name: 'make-move', methods: [Request::METHOD_POST], format: 'json')]
    public function makeMove(#[MapRequestPayload] MakeMoveDTO $makeMoveDTO): JsonResponse
    {
        $result = $this->gamesModule->makeMove($makeMoveDTO->x, $makeMoveDTO->y, $makeMoveDTO->piece);

        return match (true) {
            $result instanceof PositionInBoardAlreadyTaken => $this->json(
                ['message' => 'Position in board already taken'],
                Response::HTTP_CONFLICT
            ),
            $result instanceof PiecePlacedOutOfTurn => $this->json(
                ['message' => 'Piece placed out of turn'],
                Response::HTTP_NOT_ACCEPTABLE
            ),
            $result === null => $this->getCurrentGameState()
        };
    }

    #[Route(path: '/restart', name: 'reset', methods: [Request::METHOD_POST], format: 'json')]
    public function reset(): JsonResponse
    {
        $this->gamesModule->reset();
        return $this->getCurrentGameState();
    }

    #[Route(path: '/', name: 'remove-game', methods: [Request::METHOD_DELETE], format: 'json')]
    public function removeGame(): JsonResponse
    {
        $this->gamesModule->removeGame();
        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    private function getCurrentGameState(): JsonResponse
    {
        $result = $this->gamesModule->getCurrentGameState();

        if ($result instanceof GameNotStartedYet) {
            return $this->json(['message' => 'Game not started yet'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($result);
    }
}
