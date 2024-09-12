<?php

namespace App\Controller;

use App\Controller\DTO\MakeMoveDTO;
use App\Modules\Games\Application\Response\GameNotStartedYet;
use App\Modules\Games\GamesModule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    public function __construct(private readonly GamesModule $gamesModule)
    {
    }

    #[Route('/', name: 'start-game', methods: ['GET'], format: 'json')]
    public function startGame(): JsonResponse
    {
        $this->gamesModule->startGame();

        return $this->getCurrentGameState();
    }

    #[Route('/move', name: 'make-move', methods: ['POST'], format: 'json')]
    public function makeMove(#[MapRequestPayload] MakeMoveDTO $makeMoveDTO): JsonResponse
    {
        $this->gamesModule->makeMove($makeMoveDTO->x, $makeMoveDTO->y, $makeMoveDTO->piece);
        return $this->getCurrentGameState();
    }

    #[Route('/restart', name: 'reset', methods: ['POST'], format: 'json')]
    public function reset(): JsonResponse
    {
        $this->gamesModule->reset();
        return $this->getCurrentGameState();
    }

    #[Route('/', name: 'remove-game', methods: ['DELETE'], format: 'json')]
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
