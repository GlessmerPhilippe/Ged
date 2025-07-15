<?php

namespace App\Entity;

use App\Repository\GedDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GedDocumentRepository::class)]
class GedDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $date = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'gedDocuments')]
    private Collection $person;

    #[ORM\Column(nullable: true)]
    private ?array $tags = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $gscPath = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $mineType = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'getDocumentPost')]
    private ?User $poster = null;

    #[ORM\ManyToOne(inversedBy: 'gedDocuments')]
    private ?GedCategorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'gedDocuments')]
    private ?GedCategorieItem $ItemCategorie = null;



    public function __construct()
    {
        $this->person = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPerson(): Collection
    {
        return $this->person;
    }

    public function addPerson(User $person): static
    {
        if (!$this->person->contains($person)) {
            $this->person->add($person);
        }

        return $this;
    }

    public function removePerson(User $person): static
    {
        $this->person->removeElement($person);

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    public function getGscPath(): ?string
    {
        return $this->gscPath;
    }

    public function setGscPath(?string $gscPath): static
    {
        $this->gscPath = $gscPath;

        return $this;
    }

    public function getMineType(): ?string
    {
        return $this->mineType;
    }

    public function setMineType(?string $mineType): static
    {
        $this->mineType = $mineType;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPoster(): ?User
    {
        return $this->poster;
    }

    public function setPoster(?User $poster): static
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCategorie(): ?GedCategorie
    {
        return $this->categorie;
    }

    public function setCategorie(?GedCategorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getItemCategorie(): ?GedCategorieItem
    {
        return $this->ItemCategorie;
    }

    public function setItemCategorie(?GedCategorieItem $ItemCategorie): static
    {
        $this->ItemCategorie = $ItemCategorie;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }


}
