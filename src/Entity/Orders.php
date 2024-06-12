<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    public const STATUS_PENDING = 'en_attente';
    public const STATUS_IN_PROGRESS = 'en_cours';
    public const STATUS_DELIVERED = 'livrée';
    public const STATUS_CANCELLED = 'annulée';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $Name_Order = null;

    #[ORM\Column(length: 50)]
    private ?string $Date_Order = null;

    #[ORM\Column(length: 255, options: ['default' => self::STATUS_PENDING])]
    #[Assert\Choice(
        choices: [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED
        ],
        message: "Choose a valid status."
    )]
    private ?string $Statut_Command = self::STATUS_PENDING;

    /**
     * @var Collection<int, Meals>
     */
    #[ORM\ManyToMany(targetEntity: Meals::class, inversedBy: 'orders')]
    private Collection $Category;

    /**
     * @var Collection<int, Menus>
     */
    #[ORM\ManyToMany(targetEntity: Menus::class, inversedBy: 'orders')]
    private Collection $Category2;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Users $parent = null;

    public function __construct()
    {
        $this->Category = new ArrayCollection();
        $this->Category2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameOrder(): ?int
    {
        return $this->Name_Order;
    }

    public function setNameOrder(?int $Name_Order): static
    {
        $this->Name_Order = $Name_Order;

        return $this;
    }

    public function getDateOrder(): ?string
    {
        return $this->Date_Order;
    }

    public function setDateOrder(string $Date_Order): static
    {
        $this->Date_Order = $Date_Order;

        return $this;
    }

    public function getStatutCommand(): ?string
    {
        return $this->Statut_Command;
    }

    public function setStatutCommand(string $Statut_Command): static
    {
        if (!in_array($Statut_Command, [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED
        ])) {
            throw new \InvalidArgumentException("Invalid status");
        }

        $this->Statut_Command = $Statut_Command;

        return $this;
    }

    /**
     * @return Collection<int, Meals>
     */
    public function getCategory(): Collection
    {
        return $this->Category;
    }

    public function addCategory(Meals $category): static
    {
        if (!$this->Category->contains($category)) {
            $this->Category->add($category);
        }

        return $this;
    }

    public function removeCategory(Meals $category): static
    {
        $this->Category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Menus>
     */
    public function getCategory2(): Collection
    {
        return $this->Category2;
    }

    public function addCategory2(Menus $category2): static
    {
        if (!$this->Category2->contains($category2)) {
            $this->Category2->add($category2);
        }

        return $this;
    }

    public function removeCategory2(Menus $category2): static
    {
        $this->Category2->removeElement($category2);

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
