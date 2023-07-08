<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?int $cp = null;

    #[ORM\Column(nullable: true)]
    private ?int $idGerant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tokenEntreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;


    public function __construct()
    {
        $this->tokenEntreprise = bin2hex(random_bytes(32));
    }
    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getIdGerant(): ?int
    {
        return $this->idGerant;
    }

    public function setIdGerant(?int $idGerant): self
    {
        $this->idGerant = $idGerant;

        return $this;
    }

    public function getTokenEntreprise(): ?string
    {
        return $this->tokenEntreprise;
    }

    public function setTokenEntreprise(?string $tokenEntreprise): self
    {
        $this->tokenEntreprise = $tokenEntreprise;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

}
