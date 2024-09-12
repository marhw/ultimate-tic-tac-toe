<?php

namespace App\Modules\Games\Infrastructure\Doctrine;

use App\Modules\Games\Domain\Game;
use App\Modules\Games\Domain\GameRepository;
use App\Modules\Games\Domain\TicTacToe\TicTacToeGame;
use App\Modules\Games\Infrastructure\Doctrine\Documents\TicTacToeGameDocument;
use App\Modules\Games\Infrastructure\Doctrine\Mappers\TicTacToeGameMapper;
use App\Modules\Games\Infrastructure\Doctrine\Wrappers\TicTacToeGameWrapper;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class MongoGameRepository implements GameRepository
{
    /** @var DocumentRepository<TicTacToeGameDocument> */
    private DocumentRepository $repository;

    public function __construct(private readonly DocumentManager $documentManager)
    {
        $this->repository = $this->documentManager->getRepository(TicTacToeGameDocument::class);
    }

    public function findGame(): Game | null
    {
        $document = $this->repository->findOneBy([]);

        if ($document === null) {
            return null;
        }

        return new TicTacToeGameWrapper($document);
    }

    public function findRawTicTacToeGame(): TicTacToeGameDocument | null
    {
        return $this->repository->findOneBy([]);
    }

    public function save(Game $game): void
    {
        if (!($game instanceof TicTacToeGame)) {
            return;
        }

        $document = $game instanceof TicTacToeGameWrapper
            ? $game->applyChangesAndGetDoc()
            : TicTacToeGameMapper::mapGameObjectToDocument($game);

        $this->documentManager->persist($document);
        $this->documentManager->flush();
    }

    public function remove(Game $game): void
    {
        $document = $this->repository->findOneBy([]);

        if ($document === null) {
            return;
        }

        $this->documentManager->remove($document);
        $this->documentManager->flush();
    }

    public function isGameInProgress(): bool
    {
        $document = $this->repository->findOneBy([]);
        return $document !== null;
    }
}
