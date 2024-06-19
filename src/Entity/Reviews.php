<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 150)]
    private ?string $Title_Review = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\NotNull]
    private ?int $Note = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private ?string $Description_Review = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?Users $parent = null;

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

    public function getNote(): ?int
    {
        return $this->Note;
    }

    public function setNote(?int $Note): static
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

    public function getParent(): ?Users
    {
        return $this->parent;
    }

    public function setParent(?Users $parent): static
    {
        $this->parent = $parent;

        return $this;
    }
}
