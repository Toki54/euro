<?php

namespace App\Entity;

use App\Repository\EuromillionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EuromillionsRepository::class)]
class Euromillions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $boule_1 = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $boule_2 = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $boule_3 = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $boule_4 = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $boule_5 = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $etoile_1 = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $etoile_2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoule1(): ?int
    {
        return $this->boule_1;
    }

    public function setBoule1(?int $boule_1): static
    {
        $this->boule_1 = $boule_1;
        return $this;
    }

    public function getBoule2(): ?int
    {
        return $this->boule_2;
    }

    public function setBoule2(?int $boule_2): static
    {
        $this->boule_2 = $boule_2;
        return $this;
    }

    public function getBoule3(): ?int
    {
        return $this->boule_3;
    }

    public function setBoule3(?int $boule_3): static
    {
        $this->boule_3 = $boule_3;
        return $this;
    }

    public function getBoule4(): ?int
    {
        return $this->boule_4;
    }

    public function setBoule4(?int $boule_4): static
    {
        $this->boule_4 = $boule_4;
        return $this;
    }

    public function getBoule5(): ?int
    {
        return $this->boule_5;
    }

    public function setBoule5(?int $boule_5): static
    {
        $this->boule_5 = $boule_5;
        return $this;
    }

    public function getEtoile1(): ?int
    {
        return $this->etoile_1;
    }

    public function setEtoile1(?int $etoile_1): static
    {
        $this->etoile_1 = $etoile_1;
        return $this;
    }

    public function getEtoile2(): ?int
    {
        return $this->etoile_2;
    }

    public function setEtoile2(?int $etoile_2): static
    {
        $this->etoile_2 = $etoile_2;
        return $this;
    }
}
