<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    private ?string  $fullName = null;

    /**
     * @var Collection<int, GedDocument>
     */
    #[ORM\ManyToMany(targetEntity: GedDocument::class, mappedBy: 'person')]
    private Collection $gedDocuments;

    /**
     * @var Collection<int, GedDocument>
     */
    #[ORM\OneToMany(targetEntity: GedDocument::class, mappedBy: 'poster')]
    private Collection $getDocumentPost;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $civilite = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $naissanceAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $avatar = null;

    public function __construct()
    {
        $this->gedDocuments = new ArrayCollection();
        $this->getDocumentPost = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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
            $gedDocument->addPerson($this);
        }

        return $this;
    }

    public function removeGedDocument(GedDocument $gedDocument): static
    {
        if ($this->gedDocuments->removeElement($gedDocument)) {
            $gedDocument->removePerson($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, GedDocument>
     */
    public function getGetDocumentPost(): Collection
    {
        return $this->getDocumentPost;
    }

    public function addGetDocumentPost(GedDocument $getDocumentPost): static
    {
        if (!$this->getDocumentPost->contains($getDocumentPost)) {
            $this->getDocumentPost->add($getDocumentPost);
            $getDocumentPost->setPoster($this);
        }

        return $this;
    }

    public function removeGetDocumentPost(GedDocument $getDocumentPost): static
    {
        if ($this->getDocumentPost->removeElement($getDocumentPost)) {
            // set the owning side to null (unless already changed)
            if ($getDocumentPost->getPoster() === $this) {
                $getDocumentPost->setPoster(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(?string $civilite): static
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNaissanceAt(): ?\DateTime
    {
        return $this->naissanceAt;
    }

    public function setNaissanceAt(?\DateTime $naissanceAt): static
    {
        $this->naissanceAt = $naissanceAt;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }
    public function getFullName(): ?string
    {
        if ($this->fullName === null) {
            $this->fullName = trim(sprintf('%s %s %s', $this->civilite, $this->prenom, $this->nom));
        }
        return $this->fullName;
    }
}
