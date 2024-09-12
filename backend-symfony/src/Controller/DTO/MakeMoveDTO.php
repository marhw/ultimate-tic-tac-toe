<?php

namespace App\Controller\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class MakeMoveDTO
{
    public function __construct(
        #[Assert\NotBlank,
    Assert\GreaterThan(0)]
        public int $x,
        #[Assert\NotBlank,
    Assert\GreaterThan(0)]
        public int $y,
        #[Assert\NotBlank]
        public string $piece,
    ) {
    }
}
