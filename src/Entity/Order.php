<?php

namespace App\Entity;

use App\Enum\Order\OrderDeliveryType;
use App\Enum\Order\OrderStatus;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Assert\Uuid]
    private UuidV7 $id;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private User $relatedUser;

    #[ORM\Column(length: 32)]
    #[Assert\Choice(
        callback: [OrderStatus::class, 'values'],
        message: 'Недопустимый статус заказа'
    )]
    private string $status;

    #[ORM\Column(length: 16)]
    #[AppAssert\Phone]
    private string $phone;

    #[ORM\Column(length: 16)]
    #[Assert\Choice(
        callback: [OrderDeliveryType::class, 'values'],
        message: 'Недопустимый тип доставки'
    )]
    private string $deliveryType;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'relatedOrder', orphanRemoval: true)]
    private Collection $items;

    public function __construct(?UuidV7 $id = null)
    {
        $this->id    = $id ?? Uuid::v7();
        $this->items = new ArrayCollection();
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getRelatedUser(): User
    {
        return $this->relatedUser;
    }

    public function setRelatedUser(User $relatedUser): static
    {
        $this->relatedUser = $relatedUser;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    public function getDeliveryType(): string
    {
        return $this->deliveryType;
    }

    public function setDeliveryType(string $deliveryType): static
    {
        $this->deliveryType = $deliveryType;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setRelatedOrder($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $item): static
    {
        $this->items->removeElement($item);
        return $this;
    }
}
