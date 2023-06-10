<?php

namespace App\Entity;

use App\Repository\SiteUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteUserRepository::class)]
class SiteUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Site::class, inversedBy: 'siteUsers')]
    private Collection $SiteId;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'siteUsers')]
    private Collection $SiteUser;

    public function __construct()
    {
        $this->SiteId = new ArrayCollection();
        $this->SiteUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Site>
     */
    public function getSiteId(): Collection
    {
        return $this->SiteId;
    }

    public function addSiteId(Site $siteId): self
    {
        if (!$this->SiteId->contains($siteId)) {
            $this->SiteId->add($siteId);
        }

        return $this;
    }

    public function removeSiteId(Site $siteId): self
    {
        $this->SiteId->removeElement($siteId);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSiteUser(): Collection
    {
        return $this->SiteUser;
    }

    public function addSiteUser(User $siteUser): self
    {
        if (!$this->SiteUser->contains($siteUser)) {
            $this->SiteUser->add($siteUser);
        }

        return $this;
    }

    public function removeSiteUser(User $siteUser): self
    {
        $this->SiteUser->removeElement($siteUser);

        return $this;
    }
}
