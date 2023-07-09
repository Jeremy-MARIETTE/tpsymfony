<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column]
    private ?int $nbLicences = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePaiement = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    #[ORM\Column(length: 255)]
    private ?string $entreprise = null;

    #[ORM\OneToMany(mappedBy: 'Abo', targetEntity: User::class)]
    private Collection $Abo;


    public function __construct()
    {
        // Create a new DateTimeImmutable object instead of DateTime
        $this->datePaiement = new \DateTimeImmutable();

        $this->isValid = false;
        $this->Abo = new ArrayCollection();
  
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Abonnement
    {
        $this->id = $id;

        return $this;
    }
 

    public function getNbLicences(): ?int
    {
        return $this->nbLicences;
    }

    public function setNbLicences(int $nbLicences): self
    {
        $this->nbLicences = $nbLicences;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

 
}
