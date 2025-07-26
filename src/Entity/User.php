<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidV7 $id;

    #[ORM\Column(length: 64)]
    #[Assert\Length(max: 64)]
    private string $name;

    #[ORM\Column(length: 16, unique: true)]
    #[AppAssert\Phone]
    private string $phone;

    #[ORM\Column(length: 64, unique: true)]
    #[Assert\Length(max: 64)]
    private string $email;

    #[ORM\Column(type: Types::TEXT)]
    private string $password;

    #[ORM\OneToOne(mappedBy: 'relatedUser', cascade: ['persist', 'remove'])]
    private Cart $cart;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'relatedUser', orphanRemoval: true)]
    private Collection $orders;

    public function __construct(?UuidV7 $id = null)
    {
        $this->id     = $id ?? UuidV7::v7();
        $this->orders = new ArrayCollection();
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): static
    {
        // set the owning side of the relation if necessary
        if ($cart->getRelatedUser() !== $this) {
            $cart->setRelatedUser($this);
        }

        $this->cart = $cart;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setRelatedUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        $this->orders->removeElement($order);

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_ADMIN'];
    }

    public function eraseCredentials(): void{}

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
