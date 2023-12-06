<?php

namespace App\Entity;

use App\Repository\ProgramsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgramsRepository::class)]
class Programs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $year = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $fileSrc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getFileSrc(): ?string
    {
        return $this->fileSrc;
    }

    public function setFileSrc(string $fileSrc): static
    {
        $this->fileSrc = $fileSrc;

        return $this;
    }
}
