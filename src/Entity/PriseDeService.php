<?php

namespace App\Entity;

use App\Repository\PriseDeServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriseDeServiceRepository::class)]
class PriseDeService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'idAgent')]
    private ?User $idAgent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $latDebut = null;

    #[ORM\Column(length: 255)]
    private ?string $lngDebut = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latFin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lntFin = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAgent(): ?User
    {
        return $this->idAgent;
    }

    public function setIdAgent(?User $idAgent): self
    {
        $this->idAgent = $idAgent;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getLatDebut(): ?string
    {
        return $this->latDebut;
    }

    public function setLatDebut(string $latDebut): self
    {
        $this->latDebut = $latDebut;

        return $this;
    }

    public function getLngDebut(): ?string
    {
        return $this->lngDebut;
    }

    public function setLngDebut(string $lngDebut): self
    {
        $this->lngDebut = $lngDebut;

        return $this;
    }

    public function getLatFin(): ?string
    {
        return $this->latFin;
    }

    public function setLatFin(?string $latFin): self
    {
        $this->latFin = $latFin;

        return $this;
    }

    public function getLntFin(): ?string
    {
        return $this->lntFin;
    }

    public function setLntFin(?string $lntFin): self
    {
        $this->lntFin = $lntFin;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
