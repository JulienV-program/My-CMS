<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PuppysRepository")
 */
class Puppys
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
    private $Description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Carrousel", cascade={"persist", "remove"})
     */
    private $Carrousel;

    /**
     * @ORM\Column(type="datetime")
     */
    private $PostedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

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

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->PostedAt;
    }

    public function setPostedAt(\DateTimeInterface $PostedAt): self
    {
        $this->PostedAt = $PostedAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }
}
