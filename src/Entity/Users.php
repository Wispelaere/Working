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
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', columns: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Vous avez déjà un compte avec cette adresse email.')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $confirmationToken = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isAdmin = false;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $phoneNumber = null;

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

    public function setEmail(string $email): self
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
     * @return array<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
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
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Announces>
     */
    public function getAnnounces(): Collection
    {
        return $this->announces;
    }

    public function addAnnounce(Announces $announce): self
    {
        if (!$this->announces->contains($announce)) {
            $this->announces->add($announce);
            $announce->setParent($this);
        }

        return $this;
    }

    public function removeAnnounce(Announces $announce): self
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

    public function addMeeting(Meetings $meeting): self
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings->add($meeting);
            $meeting->setParent($this);
        }

        return $this;
    }

    public function removeMeeting(Meetings $meeting): self
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

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setParent($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
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

    public function addReview(Reviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setParent($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
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

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setParent($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getParent() === $this) {
                $order->setParent(null);
            }
        }

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }
}
