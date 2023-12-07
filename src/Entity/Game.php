<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("getData")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("getData")]
    private ?string $word = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("getData")]
    private ?\DateTimeInterface $created_date = null;

    #[ORM\Column]
    #[Groups("getData")]
    private ?bool $finished = null;

    #[ORM\Column]
    #[Groups("getData")]
    private ?int $try = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?User $player = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): static
    {
        $this->word = $word;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): static
    {
        $this->created_date = $created_date;

        return $this;
    }

    public function isFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): static
    {
        $this->finished = $finished;

        return $this;
    }

    public function getTry(): ?int
    {
        return $this->try;
    }

    public function setTry(int $try): static
    {
        $this->try = $try;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): static
    {
        $this->player = $player;

        return $this;
    }
}
