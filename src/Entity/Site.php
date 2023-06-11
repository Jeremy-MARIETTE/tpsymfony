<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $cp = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Poste::class)]
    private Collection $postes;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Consignes::class)]
    private Collection $consignes;


    public function __construct()
    {
        $this->agent = new ArrayCollection();
        $this->rapports = new ArrayCollection();
        $this->siteUsers = new ArrayCollection();
        $this->posteTravails = new ArrayCollection();
        $this->postes = new ArrayCollection();
        $this->consignes = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAgent(): Collection
    {
        return $this->agent;
    }

    public function addAgent(User $agent): self
    {
        if (!$this->agent->contains($agent)) {
            $this->agent->add($agent);
        }

        return $this;
    }

    public function removeAgent(User $agent): self
    {
        $this->agent->removeElement($agent);

        return $this;
    }

    public function getRapport(): ?Rapport
    {
        return $this->rapport;
    }

    public function setRapport(?Rapport $rapport): self
    {
        $this->rapport = $rapport;

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

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports->add($rapport);
            $rapport->setSite($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapports->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getSite() === $this) {
                $rapport->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Poste>
     */
    public function getPostes(): Collection
    {
        return $this->postes;
    }

    public function addPoste(Poste $poste): self
    {
        if (!$this->postes->contains($poste)) {
            $this->postes->add($poste);
            $poste->setSite($this);
        }

        return $this;
    }

    public function removePoste(Poste $poste): self
    {
        if ($this->postes->removeElement($poste)) {
            // set the owning side to null (unless already changed)
            if ($poste->getSite() === $this) {
                $poste->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consignes>
     */
    public function getConsignes(): Collection
    {
        return $this->consignes;
    }

    public function addConsigne(Consignes $consigne): self
    {
        if (!$this->consignes->contains($consigne)) {
            $this->consignes->add($consigne);
            $consigne->setSite($this);
        }

        return $this;
    }

    public function removeConsigne(Consignes $consigne): self
    {
        if ($this->consignes->removeElement($consigne)) {
            // set the owning side to null (unless already changed)
            if ($consigne->getSite() === $this) {
                $consigne->setSite(null);
            }
        }

        return $this;
    }

}
