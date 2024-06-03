<?php

namespace App\Entity;

use App\Repository\MealsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MealsRepository::class)]
class Meals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name_Meal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description_Meal = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\Positive(message: "Le prix doit être au dessus de 0")]
    private ?string $Price_Meal = null;

    /**
     * @var Collection<int, Orders>
     */
    #[ORM\ManyToMany(targetEntity: Orders::class, mappedBy: 'Category')]
    private Collection $orders;

    /**
     * @var Collection<int, Menus>
     */
    #[ORM\ManyToMany(targetEntity: Menus::class, mappedBy: 'Category3')]
    private Collection $menuses;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->menuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMeal(): ?string
    {
        return $this->Name_Meal;
    }

    public function setNameMeal(string $Name_Meal): static
    {
        $this->Name_Meal = $Name_Meal;

        return $this;
    }

    public function getDescriptionMeal(): ?string
    {
        return $this->Description_Meal;
    }

    public function setDescriptionMeal(?string $Description_Meal): static
    {
        $this->Description_Meal = $Description_Meal;

        return $this;
    }

    public function getPriceMeal(): ?string
    {
        return $this->Price_Meal;
    }

    public function setPriceMeal(?string $Price_Meal): static
    {
        $this->Price_Meal = $Price_Meal;

        return $this;
    }

    /**
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->addCategory($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Menus>
     */
    public function getMenuses(): Collection
    {
        return $this->menuses;
    }

    public function addMenus(Menus $menus): static
    {
        if (!$this->menuses->contains($menus)) {
            $this->menuses->add($menus);
            $menus->addCategory3($this);
        }

        return $this;
    }

    public function removeMenus(Menus $menus): static
    {
        if ($this->menuses->removeElement($menus)) {
            $menus->removeCategory3($this);
        }

        return $this;
    }
}
