<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 2, nullable: true)]
    private ?string $countryCode = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $isPremium = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $lastActiveAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Device::class)]
    private Collection $devices;

    public function __construct()
    {
        $this->devices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function isPremium(): ?bool
    {
        return $this->isPremium;
    }
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }
    public function getLastActiveAt(): \DateTimeImmutable
    {
        return $this->lastActiveAt;
    }
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getDevices(): Collection
    {
        return $this->devices;
    }

    // Setters
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }
    public function setIsPremium(?bool $isPremium): self
    {
        $this->isPremium = $isPremium;
        return $this;
    }
    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }
    public function setLastActiveAt(\DateTimeImmutable $lastActiveAt): self
    {
        $this->lastActiveAt = $lastActiveAt;
        return $this;
    }
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
