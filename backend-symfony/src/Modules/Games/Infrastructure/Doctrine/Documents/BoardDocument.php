<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Documents;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\EmbeddedDocument]
class BoardDocument
{
    #[MongoDB\Field(type: "int")]
    private int $sizeX;

    #[MongoDB\Field(type: "int")]
    private int $sizeY;

    #[MongoDB\EmbedMany(targetDocument: BoardElementDocument::class, storeEmptyArray: true)]
    private ArrayCollection $elements;

    public function __construct()
    {
        $this->elements = new ArrayCollection();
    }

    public function getSizeX(): int
    {
        return $this->sizeX;
    }

    public function setSizeX(int $sizeX): void
    {
        $this->sizeX = $sizeX;
    }

    public function getSizeY(): int
    {
        return $this->sizeY;
    }

    public function setSizeY(int $sizeY): void
    {
        $this->sizeY = $sizeY;
    }

    /**
     * @return ArrayCollection<int, BoardElementDocument>
     */
    public function getElements(): ArrayCollection
    {
        return $this->elements;
    }

    /**
     * @param array<BoardElementDocument> $elements
     */
    public function setElements(array $elements): void
    {
        foreach ($elements as $element) {
            $this->elements->add($element);
        }
    }
}
