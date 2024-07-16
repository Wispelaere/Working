<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
class Menus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $Name_Menu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $Price_Menu = null;

    /**
     * @var Collection<int, Orders>
     */
    #[ORM\ManyToMany(targetEntity: Orders::class, mappedBy: 'Category2')]
    private Collection $orders;

    /**
     * @var Collection<int, Meals>
     */
    #[ORM\ManyToMany(targetEntity: Meals::class, inversedBy: 'menuses')]
    private Collection $Category3;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->Category3 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMenu(): ?string
    {
        return $this->Name_Menu;
    }

    public function setNameMenu(string $Name_Menu): static
    {
        $this->Name_Menu = $Name_Menu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPriceMenu(): ?string
    {
        return $this->Price_Menu;
    }

    public function setPriceMenu(?string $Price_Menu): static
    {
        $this->Price_Menu = $Price_Menu;

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
            $order->addCategory2($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removeCategory2($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Meals>
     */
    public function getCategory3(): Collection
    {
        return $this->Category3;
    }

    public function addCategory3(Meals $category3): static
    {
        if (!$this->Category3->contains($category3)) {
            $this->Category3->add($category3);
        }

        return $this;
    }

    public function removeCategory3(Meals $category3): static
    {
        $this->Category3->removeElement($category3);

        return $this;
    }
}
