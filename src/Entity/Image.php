<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NamePhoto = null;

    #[ORM\Column(length: 255)]
    private ?string $Path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamePhoto(): ?string
    {
        return $this->NamePhoto;
    }

    public function setNamePhoto(string $NamePhoto): static
    {
        $this->NamePhoto = $NamePhoto;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->Path;
    }

    public function setPath(string $Path): static
    {
        $this->Path = $Path;

        return $this;
    }
}
