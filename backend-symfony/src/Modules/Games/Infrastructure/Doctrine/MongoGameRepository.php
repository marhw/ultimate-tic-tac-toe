<?php

namespace App\Modules\Games\Infrastructure\Doctrine;

use App\Modules\Games\Domain\Game;
use App\Modules\Games\Domain\GameRepository;
use App\Modules\Games\Domain\TicTacToe\TicTacToeGame;
use App\Modules\Games\Infrastructure\Doctrine\Mappers\TicTacToeGameMapper;
use Doctrine\ODM\MongoDB\DocumentManager;

class MongoGameRepository implements GameRepository
{
    public function __construct(private readonly DocumentManager $documentManager)
    {
    }

    public function findGame(): ?Game
    {
        return null;
    }

    public function save(Game $game): void
    {
        if ($game instanceof TicTacToeGame) {
            $document = TicTacToeGameMapper::mapGameObjectToDocument($game);
            $this->documentManager->persist($document);
            $this->documentManager->flush();
        }
    }

    public function remove(Game $game): void
    {
        $this->documentManager->flush();
    }
}
