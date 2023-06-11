<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'caterory', targetEntity: Livre::class)]
    private Collection $livres;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Rapport::class)]
    private Collection $rapports;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Consignes::class)]
    private Collection $content;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
        $this->rapports = new ArrayCollection();
        $this->content = new ArrayCollection();
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

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->setCaterory($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getCaterory() === $this) {
                $livre->setCaterory(null);
            }
        }

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
            $rapport->setCategory($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapports->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getCategory() === $this) {
                $rapport->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consignes>
     */
    public function getContent(): Collection
    {
        return $this->content;
    }

    public function addContent(Consignes $content): self
    {
        if (!$this->content->contains($content)) {
            $this->content->add($content);
            $content->setCategory($this);
        }

        return $this;
    }

    public function removeContent(Consignes $content): self
    {
        if ($this->content->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getCategory() === $this) {
                $content->setCategory(null);
            }
        }

        return $this;
    }
}
