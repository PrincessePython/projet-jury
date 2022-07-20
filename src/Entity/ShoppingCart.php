<?php

namespace App\Entity;

use App\Repository\ShoppingCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingCartRepository::class)]
class ShoppingCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $total_price;

    #[ORM\OneToOne(inversedBy: 'shoppingCart', targetEntity: Users::class, cascade: ['persist', 'remove'])]
    private $users;

    #[ORM\OneToMany(mappedBy: 'shoppingCart', targetEntity: Products::class)]
    private $Products;

    public function __construct()
    {
        $this->Products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalPrice(): ?string
    {
        return $this->total_price;
    }

    public function setTotalPrice(?string $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->Products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->Products->contains($product)) {
            $this->Products[] = $product;
            $product->setShoppingCart($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->Products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getShoppingCart() === $this) {
                $product->setShoppingCart(null);
            }
        }

        return $this;
    }
}
