<?php

namespace App\Entity;

use App\Repository\InvertebreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvertebreRepository::class)]
class Invertebre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateAjout = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'invertebres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EspeceInvertebre $espece = null;

    #[ORM\ManyToOne(inversedBy: 'invertebres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aquarium $aquarium = null;

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

    public function getDateAjout(): ?\DateTimeImmutable
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeImmutable $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getEspece(): ?EspeceInvertebre
    {
        return $this->espece;
    }

    public function setEspece(?EspeceInvertebre $espece): static
    {
        $this->espece = $espece;

        return $this;
    }

    public function getAquarium(): ?Aquarium
    {
        return $this->aquarium;
    }

    public function setAquarium(?Aquarium $aquarium): static
    {
        $this->aquarium = $aquarium;

        return $this;
    }
}
