<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Vous avez deja un compte sur cette adresse Email')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $First_Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Last_Name = null;

    #[ORM\Column]
    private ?bool $IsAdmin = false;

    #[ORM\Column(length: 255)]
    private ?string $Adress = null;

    #[ORM\Column(length: 20)]
    private ?string $Phone_Number = null;

    /**
     * @var Collection<int, Announces>
     */
    #[ORM\OneToMany(targetEntity: Announces::class, mappedBy: 'parent')]
    private Collection $announces;

    /**
     * @var Collection<int, Meetings>
     */
    #[ORM\OneToMany(targetEntity: Meetings::class, mappedBy: 'parent')]
    private Collection $meetings;

    /**
     * @var Collection<int, Album>
     */
    #[ORM\OneToMany(targetEntity: Album::class, mappedBy: 'parent')]
    private Collection $albums;

    /**
     * @var Collection<int, Reviews>
     */
    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'parent')]
    private Collection $reviews;

    /**
     * @var Collection<int, Orders>
     */
    #[ORM\OneToMany(targetEntity: Orders::class, mappedBy: 'parent')]
    private Collection $orders;

    public function __construct()
    {
        $this->announces = new ArrayCollection();
        $this->meetings = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->First_Name;
    }

    public function setFirstName(string $First_Name): static
    {
        $this->First_Name = $First_Name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->Last_Name;
    }

    public function setLastName(string $Last_Name): static
    {
        $this->Last_Name = $Last_Name;

        return $this;
    }

    public function isAdmin(): ?bool
    {
        return $this->IsAdmin;
    }

    public function setAdmin(bool $IsAdmin): static
    {
        $this->IsAdmin = $IsAdmin;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(string $Adress): static
    {
        $this->Adress = $Adress;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->Phone_Number;
    }

    public function setPhoneNumber(string $Phone_Number): static
    {
        $this->Phone_Number = $Phone_Number;

        return $this;
    }

    /**
     * @return Collection<int, Announces>
     */
    public function getAnnounces(): Collection
    {
        return $this->announces;
    }

    public function addAnnounce(Announces $announce): static
    {
        if (!$this->announces->contains($announce)) {
            $this->announces->add($announce);
            $announce->setParent($this);
        }

        return $this;
    }

    public function removeAnnounce(Announces $announce): static
    {
        if ($this->announces->removeElement($announce)) {
            // set the owning side to null (unless already changed)
            if ($announce->getParent() === $this) {
                $announce->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Meetings>
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meetings $meeting): static
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings->add($meeting);
            $meeting->setParent($this);
        }

        return $this;
    }

    public function removeMeeting(Meetings $meeting): static
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getParent() === $this) {
                $meeting->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setParent($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getParent() === $this) {
                $album->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setParent($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getParent() === $this) {
                $review->setParent(null);
            }
        }

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
            $order->setParent($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getParent() === $this) {
                $order->setParent(null);
            }
        }

        return $this;
    }
}
