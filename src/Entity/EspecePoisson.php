<?php

namespace App\Entity;

use App\Repository\EspecePoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspecePoissonRepository::class)]
class EspecePoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $enable = null;

    /**
     * @var Collection<int, Poisson>
     */
    #[ORM\OneToMany(targetEntity: Poisson::class, mappedBy: 'espece')]
    private Collection $poissons;

    public function __construct()
    {
        $this->poissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): static
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * @return Collection<int, Poisson>
     */
    public function getPoissons(): Collection
    {
        return $this->poissons;
    }

    public function addPoisson(Poisson $poisson): static
    {
        if (!$this->poissons->contains($poisson)) {
            $this->poissons->add($poisson);
            $poisson->setEspece($this);
        }

        return $this;
    }

    public function removePoisson(Poisson $poisson): static
    {
        if ($this->poissons->removeElement($poisson)) {
            // set the owning side to null (unless already changed)
            if ($poisson->getEspece() === $this) {
                $poisson->setEspece(null);
            }
        }

        return $this;
    }
}
