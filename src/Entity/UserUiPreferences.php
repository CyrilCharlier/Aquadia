<?php

namespace App\Entity;

use App\Repository\UserUiPreferencesRepository;
use App\Ui\Color\UserEventColors;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserUiPreferencesRepository::class)]
class UserUiPreferences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'uiPreferences', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 10, nullable: true, options: ['default' => UserEventColors::ADD_FISH])]
    private ?string $colorAddFish = UserEventColors::ADD_FISH;

    #[ORM\Column(length: 10, nullable: true, options: ['default' => UserEventColors::ADD_PLANT])]
    private ?string $colorAddPlant = UserEventColors::ADD_PLANT;

    #[ORM\Column(length: 10, nullable: true, options: ['default' => UserEventColors::ADD_INVERTEBRATE])]
    private ?string $colorAddInvertebrate = UserEventColors::ADD_INVERTEBRATE;

    #[ORM\Column(length: 10, nullable: true, options: ['default' => UserEventColors::DEFAULT_EVENT])]
    private ?string $colorDefault = UserEventColors::DEFAULT_EVENT;

    #[ORM\Column(length: 10, nullable: true, options: ['default' => UserEventColors::EVENT_TEST])]
    private ?string $colorEventTest = UserEventColors::EVENT_TEST;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getColorAddFish(): ?string
    {
        return $this->colorAddFish;
    }

    public function setColorAddFish(?string $colorAddFish): static
    {
        $this->colorAddFish = $colorAddFish;

        return $this;
    }

    public function getColorAddPlant(): ?string
    {
        return $this->colorAddPlant;
    }

    public function setColorAddPlant(?string $colorAddPlant): static
    {
        $this->colorAddPlant = $colorAddPlant;

        return $this;
    }

    public function getColorAddInvertebrate(): ?string
    {
        return $this->colorAddInvertebrate;
    }

    public function setColorAddInvertebrate(?string $colorAddInvertebrate): static
    {
        $this->colorAddInvertebrate = $colorAddInvertebrate;

        return $this;
    }

    public function getColorDefault(): ?string
    {
        return $this->colorDefault;
    }

    public function setColorDefault(?string $colorDefault): static
    {
        $this->colorDefault = $colorDefault;

        return $this;
    }

    public function getColorEventTest(): ?string
    {
        return $this->colorEventTest;
    }

    public function setColorEventTest(?string $colorEventTest): static
    {
        $this->colorEventTest = $colorEventTest;

        return $this;
    }
}
