<?php

namespace App\Entity;

use App\Repository\MeetingsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeetingsRepository::class)]
class Meetings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $Name_Meeting = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Meeting = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Time_Meeting = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMeeting(): ?string
    {
        return $this->Name_Meeting;
    }

    public function setNameMeeting(string $Name_Meeting): static
    {
        $this->Name_Meeting = $Name_Meeting;

        return $this;
    }

    public function getDateMeeting(): ?\DateTimeInterface
    {
        return $this->Date_Meeting;
    }

    public function setDateMeeting(\DateTimeInterface $Date_Meeting): static
    {
        $this->Date_Meeting = $Date_Meeting;

        return $this;
    }

    public function getTimeMeeting(): ?\DateTimeInterface
    {
        return $this->Time_Meeting;
    }

    public function setTimeMeeting(\DateTimeInterface $Time_Meeting): static
    {
        $this->Time_Meeting = $Time_Meeting;

        return $this;
    }
}
