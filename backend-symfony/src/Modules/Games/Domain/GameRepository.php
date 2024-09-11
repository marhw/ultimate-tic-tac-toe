<?php

namespace App\Modules\Games\Domain;

interface GameRepository
{
    public function findGame(): Game | null;
    public function save(Game $game): void;
    public function remove(Game $game): void;
}
