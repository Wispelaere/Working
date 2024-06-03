<?php

namespace App\Entity;

use App\Repository\AnnouncesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnouncesRepository::class)]
class Announces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $Name_Announce = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description_Announce = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date_Sent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameAnnounce(): ?string
    {
        return $this->Name_Announce;
    }

    public function setNameAnnounce(string $Name_Announce): static
    {
        $this->Name_Announce = $Name_Announce;

        return $this;
    }

    public function getDescriptionAnnounce(): ?string
    {
        return $this->Description_Announce;
    }

    public function setDescriptionAnnounce(string $Description_Announce): static
    {
        $this->Description_Announce = $Description_Announce;

        return $this;
    }

    public function getDateSent(): ?\DateTimeInterface
    {
        return $this->Date_Sent;
    }

    public function setDateSent(\DateTimeInterface $Date_Sent): static
    {
        $this->Date_Sent = $Date_Sent;

        return $this;
    }
}
