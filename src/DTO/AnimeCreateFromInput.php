<?php

namespace App\DTO;

class AnimeCreateFromInput
{
    public function __construct(
        public string $Nome = '',
        public int $Temporadas = 0,
        public int $quantidadeeps = 0,
    ) {
    }
}
