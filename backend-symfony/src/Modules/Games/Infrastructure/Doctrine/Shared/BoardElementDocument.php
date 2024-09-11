<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Shared;

/** @ODM\EmbeddedDocument */
class BoardElementDocument
{
    /** @ODM\Field(type="int") */
    private string $x;

    /** @ODM\Field(type="int") */
    private string $y;

    /** @ODM\Field(type="string") */
    private string $piece;
}
