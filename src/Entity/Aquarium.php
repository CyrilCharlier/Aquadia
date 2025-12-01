<?php

namespace App\Entity;

use App\Repository\AquariumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Enum\TypeAquarium;

#[ORM\Entity(repositoryClass: AquariumRepository::class)]
class Aquarium
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $volume = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $wateringDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $temperature = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'aquariums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?float $phMin = null;

    #[ORM\Column(nullable: true)]
    private ?float $phMax = null;

    #[ORM\Column(nullable: true)]
    private ?float $ghMin = null;

    #[ORM\Column(nullable: true)]
    private ?float $ghMax = null;

    #[ORM\Column(nullable: true)]
    private ?float $khMin = null;

    #[ORM\Column(nullable: true)]
    private ?float $khMax = null;

    #[ORM\Column(nullable: true)]
    private ?float $no2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $no3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $nhx = null;

    #[ORM\Column(nullable: true)]
    private ?float $conductiviteMax = null;

    #[ORM\Column(type: Types::STRING, enumType: TypeAquarium::class)]
    private ?TypeAquarium $typeAquarium = null;

    /**
     * @var Collection<int, Test>
     */
    #[ORM\OneToMany(targetEntity: Test::class, mappedBy: 'aquarium', orphanRemoval: true)]
    private Collection $tests;

    /**
     * @var Collection<int, Poisson>
     */
    #[ORM\OneToMany(targetEntity: Poisson::class, mappedBy: 'aquarium', orphanRemoval: true)]
    private Collection $poissons;

    /**
     * @var Collection<int, Plante>
     */
    #[ORM\OneToMany(targetEntity: Plante::class, mappedBy: 'aquarium')]
    private Collection $plantes;

    /**
     * @var Collection<int, Invertebre>
     */
    #[ORM\OneToMany(targetEntity: Invertebre::class, mappedBy: 'aquarium')]
    private Collection $invertebres;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
        $this->poissons = new ArrayCollection();
        $this->plantes = new ArrayCollection();
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

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    public function getWateringDate(): ?\DateTimeImmutable
    {
        return $this->wateringDate;
    }

    public function setWateringDate(?\DateTimeImmutable $wateringDate): static
    {
        $this->wateringDate = $wateringDate;

        return $this;
    }

    public function getTemperature(): ?int
    {
        return $this->temperature;
    }

    public function setTemperature(?int $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPhMin(): ?float
    {
        return $this->phMin;
    }

    public function setPhMin(?float $phMin): static
    {
        $this->phMin = $phMin;

        return $this;
    }

    public function getPhMax(): ?float
    {
        return $this->phMax;
    }

    public function setPhMax(?float $phMax): static
    {
        $this->phMax = $phMax;

        return $this;
    }

    public function getGhMin(): ?float
    {
        return $this->ghMin;
    }

    public function setGhMin(?float $ghMin): static
    {
        $this->ghMin = $ghMin;

        return $this;
    }

    public function getGhMax(): ?float
    {
        return $this->ghMax;
    }

    public function setGhMax(?float $ghMax): static
    {
        $this->ghMax = $ghMax;

        return $this;
    }

    public function getKhMin(): ?float
    {
        return $this->khMin;
    }

    public function setKhMin(?float $khMin): static
    {
        $this->khMin = $khMin;

        return $this;
    }

    public function getKhMax(): ?float
    {
        return $this->khMax;
    }

    public function setKhMax(?float $khMax): static
    {
        $this->khMax = $khMax;

        return $this;
    }

    public function getNo2(): ?float
    {
        return $this->no2;
    }

    public function setNo2(?float $no2): static
    {
        $this->no2 = $no2;

        return $this;
    }

    public function getNo3(): ?float
    {
        return $this->no3;
    }

    public function setNo3(?float $no3): static
    {
        $this->no3 = $no3;

        return $this;
    }

    public function getNhx(): ?float
    {
        return $this->nhx;
    }

    public function setNhx(?float $nhx): static
    {
        $this->nhx = $nhx;

        return $this;
    }

    public function getConductiviteMax(): ?float
    {
        return $this->conductiviteMax;
    }

    public function setConductiviteMax(?float $conductiviteMax): static
    {
        $this->conductiviteMax = $conductiviteMax;

        return $this;
    }

    #[Assert\Callback]
    public function validateRanges(ExecutionContextInterface $context): void
    {
        $ranges = [
            ['phMin', 'phMax'],
            ['ghMin', 'ghMax'],
            ['khMin', 'khMax'],
        ];

        foreach ($ranges as [$minField, $maxField]) {

            $min = $this->$minField;
            $max = $this->$maxField;

            if ($min !== null && $max !== null && $min > $max) {
                $context->buildViolation('La valeur minimale doit être inférieure à la valeur maximale.')
                    ->atPath($minField)
                    ->addViolation();
            }
        }
    }

    /**
     * @return Collection<int, Test>
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): static
    {
        if (!$this->tests->contains($test)) {
            $this->tests->add($test);
            $test->setAquarium($this);
        }

        return $this;
    }

    public function removeTest(Test $test): static
    {
        if ($this->tests->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getAquarium() === $this) {
                $test->setAquarium(null);
            }
        }

        return $this;
    }

    public function getTypeAquarium(): ?TypeAquarium
    {
        return $this->typeAquarium;
    }

    public function setTypeAquarium(TypeAquarium $typeAquarium): static
    {
        $this->typeAquarium = $typeAquarium;
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
            $poisson->setAquarium($this);
        }

        return $this;
    }

    public function removePoisson(Poisson $poisson): static
    {
        if ($this->poissons->removeElement($poisson)) {
            // set the owning side to null (unless already changed)
            if ($poisson->getAquarium() === $this) {
                $poisson->setAquarium(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Plante>
     */
    public function getPlantes(): Collection
    {
        return $this->plantes;
    }

    public function addPlante(Plante $plante): static
    {
        if (!$this->plantes->contains($plante)) {
            $this->plantes->add($plante);
            $plante->setAquarium($this);
        }

        return $this;
    }

    public function removePlante(Plante $plante): static
    {
        if ($this->plantes->removeElement($plante)) {
            // set the owning side to null (unless already changed)
            if ($plante->getAquarium() === $this) {
                $plante->setAquarium(null);
            }
        }

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
            $invertebre->setAquarium($this);
        }

        return $this;
    }

    public function removeInvertebre(Invertebre $invertebre): static
    {
        if ($this->invertebres->removeElement($invertebre)) {
            // set the owning side to null (unless already changed)
            if ($invertebre->getAquarium() === $this) {
                $invertebre->setAquarium(null);
            }
        }

        return $this;
    }
}
