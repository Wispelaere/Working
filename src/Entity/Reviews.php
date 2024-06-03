<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 150)]
    private ?string $Title_Review = null;

    #[ORM\Column(type: Types::BINARY)]
    #[Assert\NotNull]
    private ?string $Note = null;  // Explicitly defining as string

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $Description_Review = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleReview(): ?string
    {
        return $this->Title_Review;
    }

    public function setTitleReview(string $Title_Review): static
    {
        $this->Title_Review = $Title_Review;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->Note;
    }

    public function setNote(?string $Note): static
    {
        $this->Note = $Note;

        return $this;
    }

    public function getDescriptionReview(): ?string
    {
        return $this->Description_Review;
    }

    public function setDescriptionReview(string $Description_Review): static
    {
        $this->Description_Review = $Description_Review;

        return $this;
    }
}
