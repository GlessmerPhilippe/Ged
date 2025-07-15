<?php

namespace App\Entity;

use App\Repository\GedCategorieItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GedCategorieItemRepository::class)]
class GedCategorieItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, GedDocument>
     */
    #[ORM\OneToMany(targetEntity: GedDocument::class, mappedBy: 'ItemCategorie')]
    private Collection $gedDocuments;

    #[ORM\ManyToOne(inversedBy: 'gedCategorieItems')]
    private ?GedCategorie $cat = null;

    public function __construct()
    {
        $this->gedDocuments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, GedDocument>
     */
    public function getGedDocuments(): Collection
    {
        return $this->gedDocuments;
    }

    public function addGedDocument(GedDocument $gedDocument): static
    {
        if (!$this->gedDocuments->contains($gedDocument)) {
            $this->gedDocuments->add($gedDocument);
            $gedDocument->setItemCategorie($this);
        }

        return $this;
    }

    public function removeGedDocument(GedDocument $gedDocument): static
    {
        if ($this->gedDocuments->removeElement($gedDocument)) {
            // set the owning side to null (unless already changed)
            if ($gedDocument->getItemCategorie() === $this) {
                $gedDocument->setItemCategorie(null);
            }
        }

        return $this;
    }

    public function getCat(): ?GedCategorie
    {
        return $this->cat;
    }

    public function setCat(?GedCategorie $cat): static
    {
        $this->cat = $cat;

        return $this;
    }
}
