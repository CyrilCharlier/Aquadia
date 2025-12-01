<?php

namespace App\Entity;

use App\Repository\EspeceInvertebreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspeceInvertebreRepository::class)]
class EspeceInvertebre
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
     * @var Collection<int, Invertebre>
     */
    #[ORM\OneToMany(targetEntity: Invertebre::class, mappedBy: 'espece')]
    private Collection $invertebres;

    public function __construct()
    {
        $this->invertebres = new ArrayCollection();
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
     * @return Collection<int, Invertebre>
     */
    public function getInvertebres(): Collection
    {
        return $this->invertebres;
    }

    public function addInvertebre(Invertebre $invertebre): static
    {
        if (!$this->invertebres->contains($invertebre)) {
            $this->invertebres->add($invertebre);
            $invertebre->setEspece($this);
        }

        return $this;
    }

    public function removeInvertebre(Invertebre $invertebre): static
    {
        if ($this->invertebres->removeElement($invertebre)) {
            // set the owning side to null (unless already changed)
            if ($invertebre->getEspece() === $this) {
                $invertebre->setEspece(null);
            }
        }

        return $this;
    }
}
