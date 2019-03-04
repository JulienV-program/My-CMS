<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DogsRepository")
 */
class Dogs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Breed;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $LOF;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Carrousel", cascade={"persist", "remove"})
     */
    private $Carrousel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getBreed(): ?string
    {
        return $this->Breed;
    }

    public function setBreed(?string $Breed): self
    {
        $this->Breed = $Breed;

        return $this;
    }

    public function getLOF(): ?int
    {
        return $this->LOF;
    }

    public function setLOF(?int $LOF): self
    {
        $this->LOF = $LOF;

        return $this;
    }

    public function getCarrousel(): ?Carrousel
    {
        return $this->Carrousel;
    }

    public function setCarrousel(?Carrousel $Carrousel): self
    {
        $this->Carrousel = $Carrousel;

        return $this;
    }
}
