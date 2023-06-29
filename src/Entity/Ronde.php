<?php

namespace App\Entity;

use App\Repository\RondeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RondeRepository::class)]
class Ronde
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $debutAt = null;

    #[ORM\Column]
    private ?\DateTime $retourAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $observation = null;

    #[ORM\ManyToOne(inversedBy: 'rondes')]
    private ?Site $site = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $latDepart = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lntDepart = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $latRetour = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lntRetour = null;

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebutAt(): ?\DateTime
    {
        return $this->debutAt;
    }

    public function setDebutAt(\DateTime $debutAt): self
    {
        $this->debutAt = $debutAt;

        return $this;
    }

    public function getRetourAt(): ?\DateTime
    {
        return $this->retourAt;
    }

    public function setRetourAt(\DateTime $retourAt): self
    {
        $this->retourAt = $retourAt;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getLatDepart(): ?string
    {
        return $this->latDepart;
    }

    public function setLatDepart(?string $latDepart): self
    {
        $this->latDepart = $latDepart;

        return $this;
    }

    public function getLntDepart(): ?string
    {
        return $this->lntDepart;
    }

    public function setLntDepart(?string $lntDepart): self
    {
        $this->lntDepart = $lntDepart;

        return $this;
    }

    public function getLatRetour(): ?string
    {
        return $this->latRetour;
    }

    public function setLatRetour(?string $latRetour): self
    {
        $this->latRetour = $latRetour;

        return $this;
    }

    public function getLntRetour(): ?string
    {
        return $this->lntRetour;
    }

    public function setLntRetour(?string $lntRetour): self
    {
        $this->lntRetour = $lntRetour;

        return $this;
    }
  

   
}
