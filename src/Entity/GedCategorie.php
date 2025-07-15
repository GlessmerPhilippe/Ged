<?php

namespace App\Entity;

use App\Repository\GedCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GedCategorieRepository::class)]
class GedCategorie
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
    #[ORM\OneToMany(targetEntity: GedDocument::class, mappedBy: 'categorie')]
    private Collection $gedDocuments;

    /**
     * @var Collection<int, GedCategorieItem>
     */
    #[ORM\OneToMany(targetEntity: GedCategorieItem::class, mappedBy: 'cat')]
    private Collection $gedCategorieItems;

    public function __construct()
    {
        $this->gedDocuments = new ArrayCollection();
        $this->gedCategorieItems = new ArrayCollection();
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
            $gedDocument->setCategorie($this);
        }

        return $this;
    }

    public function removeGedDocument(GedDocument $gedDocument): static
    {
        if ($this->gedDocuments->removeElement($gedDocument)) {
            // set the owning side to null (unless already changed)
            if ($gedDocument->getCategorie() === $this) {
                $gedDocument->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GedCategorieItem>
     */
    public function getGedCategorieItems(): Collection
    {
        return $this->gedCategorieItems;
    }

    public function addGedCategorieItem(GedCategorieItem $gedCategorieItem): static
    {
        if (!$this->gedCategorieItems->contains($gedCategorieItem)) {
            $this->gedCategorieItems->add($gedCategorieItem);
            $gedCategorieItem->setCat($this);
        }

        return $this;
    }

    public function removeGedCategorieItem(GedCategorieItem $gedCategorieItem): static
    {
        if ($this->gedCategorieItems->removeElement($gedCategorieItem)) {
            // set the owning side to null (unless already changed)
            if ($gedCategorieItem->getCat() === $this) {
                $gedCategorieItem->setCat(null);
            }
        }

        return $this;
    }
}
