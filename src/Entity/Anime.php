<?php

namespace App\Entity;

use App\Repository\AnimeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimeRepository::class)]
class Anime
{

    public function __construct(
    #[ORM\Column(length: 255)]
    private ?string $nome = null,
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $temporadas = null,
    #[ORM\Column]
    private ?int $quantidadeeps = null
    )
    {

    }
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getTemporadas(): ?int
    {
        return $this->temporadas;
    }

    public function setTemporadas(int $temporadas): self
    {
        $this->temporadas = $temporadas;

        return $this;
    }

    public function getQuantidadeeps(): ?int
    {
        return $this->quantidadeeps;
    }

    public function setQuantidadeeps(int $quantidadeeps): self
    {
        $this->quantidadeeps = $quantidadeeps;

        return $this;
    }
}
