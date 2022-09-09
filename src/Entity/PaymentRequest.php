<?php

namespace App\Entity;

use App\Repository\PaymentRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRequestRepository::class)]
class PaymentRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $paid_at;

    #[ORM\Column(type: 'boolean')]
    private $is_validated;

    #[ORM\OneToOne(inversedBy: 'paymentRequest', targetEntity: Orders::class, cascade: ['persist', 'remove'])]
    private $linkToOrder;

    #[ORM\Column(type: 'string', length: 255)]
    private $stripeSessionId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paid_at;
    }

    public function setPaidAt(?\DateTimeInterface $paid_at): self
    {
        $this->paid_at = $paid_at;

        return $this;
    }

    public function isIsValidated(): ?bool
    {
        return $this->is_validated;
    }

    public function setIsValidated(bool $is_validated): self
    {
        $this->is_validated = $is_validated;

        return $this;
    }

    public function getLinkToOrder(): ?Orders
    {
        return $this->linkToOrder;
    }

    public function setLinkToOrder(?Orders $linkToOrder): self
    {
        $this->linkToOrder = $linkToOrder;

        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(string $stripeSessionId): self
    {
        $this->stripeSessionId = $stripeSessionId;

        return $this;
    }
}
