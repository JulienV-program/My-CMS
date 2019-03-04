<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $PageName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Paragraph", mappedBy="page")
     */
    private $Paragraph;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Carrousel", inversedBy="pages")
     */
    private $Carrousel;

    public function __construct()
    {
        $this->Paragraph = new ArrayCollection();
        $this->Carrousel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPageName(): ?string
    {
        return $this->PageName;
    }

    public function setPageName(string $PageName): self
    {
        $this->PageName = $PageName;

        return $this;
    }

    /**
     * @return Collection|Paragraph[]
     */
    public function getParagraph(): Collection
    {
        return $this->Paragraph;
    }

    public function addParagraph(Paragraph $paragraph): self
    {
        if (!$this->Paragraph->contains($paragraph)) {
            $this->Paragraph[] = $paragraph;
            $paragraph->setPage($this);
        }

        return $this;
    }

    public function removeParagraph(Paragraph $paragraph): self
    {
        if ($this->Paragraph->contains($paragraph)) {
            $this->Paragraph->removeElement($paragraph);
            // set the owning side to null (unless already changed)
            if ($paragraph->getPage() === $this) {
                $paragraph->setPage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Carrousel[]
     */
    public function getCarrousel(): Collection
    {
        return $this->Carrousel;
    }

    public function addCarrousel(Carrousel $carrousel): self
    {
        if (!$this->Carrousel->contains($carrousel)) {
            $this->Carrousel[] = $carrousel;
        }

        return $this;
    }

    public function removeCarrousel(Carrousel $carrousel): self
    {
        if ($this->Carrousel->contains($carrousel)) {
            $this->Carrousel->removeElement($carrousel);
        }

        return $this;
    }
}
