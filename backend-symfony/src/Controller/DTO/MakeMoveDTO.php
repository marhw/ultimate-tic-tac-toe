<?php

namespace App\Controller\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class MakeMoveDTO
{
    public function __construct(
        #[Assert\NotBlank,
    Assert\GreaterThanOrEqual(0)]
        public int $x,
        #[Assert\NotBlank,
    Assert\GreaterThanOrEqual(0)]
        public int $y,
        #[Assert\NotBlank]
        public string $piece,
    ) {
    }
}
