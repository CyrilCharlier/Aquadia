<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $ph = null;

    #[ORM\Column(nullable: true)]
    private ?float $gh = null;

    #[ORM\Column(nullable: true)]
    private ?float $kh = null;

    #[ORM\Column(nullable: true)]
    private ?float $no2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $no3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $nhx = null;

    #[ORM\Column(nullable: true)]
    private ?float $conductivite = null;

    #[ORM\ManyToOne(inversedBy: 'tests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aquarium $aquarium = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPh(): ?float
    {
        return $this->ph;
    }

    public function setPh(?float $ph): static
    {
        $this->ph = $ph;

        return $this;
    }

    public function getGh(): ?float
    {
        return $this->gh;
    }

    public function setGh(?float $gh): static
    {
        $this->gh = $gh;

        return $this;
    }

    public function getKh(): ?float
    {
        return $this->kh;
    }

    public function setKh(?float $kh): static
    {
        $this->kh = $kh;

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

    public function getConductivite(): ?float
    {
        return $this->conductivite;
    }

    public function setConductivite(?float $conductivite): static
    {
        $this->conductivite = $conductivite;

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

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
