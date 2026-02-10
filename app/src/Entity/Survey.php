<?php

namespace App\Entity;

use App\Repository\SurveyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SurveyRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'surveys')]
class Survey
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $userId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:show'])]
    private string $title;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private bool $draft = false;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['user:read'])]
    private string $slug;

    #[ORM\Column]
    #[Groups(['user:read', 'user:show'])]
    private bool $passwordRequired = false;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $password = null;

    #[ORM\OneToMany(
        mappedBy: 'survey',
        targetEntity: SurveyQuestion::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Groups(['user:read', 'user:show'])]
    private Collection $questions;

    #[ORM\OneToMany(
        mappedBy: 'survey',
        targetEntity: SurveyResult::class,
        orphanRemoval: true
    )]
    #[Groups(['user:results'])]
    private Collection $results;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['user:read'])]
    private array $extraOptions = [];

    #[ORM\Column]
    #[Groups(['user:read', 'user:show'])]
    private bool $isPublic = false;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Groups(['user:read'])]
    private \DateTimeImmutable $publicAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['user:read'])]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['user:read'])]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Groups(['user:read'])]
    private ?\DateTimeImmutable $deletedAt = null;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->results = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    #[ORM\PreUpdate]
    public function onUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function isDraft(): bool
    {
        return $this->draft;
    }

    public function setDraft(bool $draft): self
    {
        $this->draft = $draft;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function isPasswordRequired(): bool
    {
        return $this->passwordRequired;
    }

    public function setPasswordRequired(bool $passwordRequired): self
    {
        $this->passwordRequired = $passwordRequired;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return Collection<int, SurveyQuestion>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(SurveyQuestion $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    /**
     * @return Collection<int, SurveyResult>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(SurveyResult $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
        }

        return $this;
    }

    public function getExtraOptions(): array
    {
        return $this->extraOptions;
    }

    public function setExtraOptions(array $extraOptions): self
    {
        $this->extraOptions = $extraOptions;
        return $this;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;
        return $this;
    }

    public function getPublicAt(): \DateTimeImmutable
    {
        return $this->publicAt;
    }

    public function setPublicAt(\DateTimeImmutable $publicAt): self
    {
        $this->publicAt = $publicAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function softDelete(): self
    {
        $this->deletedAt = new \DateTimeImmutable();
        return $this;
    }
}
