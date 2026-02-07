<?php

namespace App\Entity;

use App\Repository\SurveyQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SurveyQuestionRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'survey_questions')]
class SurveyQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Survey $survey = null;

    #[ORM\Column(length: 32, unique: true)]
    #[Groups(['user:show'])]
    private string $uuid;

    #[ORM\Column(length: 50)]
    #[Groups(['user:read', 'user:show'])]
    private string $type;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:show'])]
    private string $title;

    #[ORM\Column]
    #[Groups(['user:read', 'user:show'])]
    private bool $visible = true;

    #[ORM\Column]
    #[Groups(['user:read', 'user:show'])]
    private int $minOptionsLimit = 0;

    #[ORM\Column]
    #[Groups(['user:read', 'user:show'])]
    private int $maxOptionsLimit = 0;

    #[ORM\Column]
    #[Groups(['user:read', 'user:show'])]
    private bool $draft = false;

    #[ORM\Column]
    #[Groups(['user:read', 'user:show'])]
    private bool $required = false;

    #[ORM\Column]
    #[Groups(['user:read', 'user:show'])]
    private bool $optional = false;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $position = null;

    #[ORM\OneToMany(
        mappedBy: 'question',
        targetEntity: SurveyQuestionOption::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Groups(['user:read', 'user:show'])]
    private Collection $options;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['user:read'])]
    private array $extraOptions = [];

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
        $this->options = new ArrayCollection();
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

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
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

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;
        return $this;
    }

    public function getMinOptionsLimit(): int
    {
        return $this->minOptionsLimit;
    }

    public function setMinOptionsLimit(int $limit): self
    {
        $this->minOptionsLimit = $limit;
        return $this;
    }

    public function getMaxOptionsLimit(): int
    {
        return $this->maxOptionsLimit;
    }

    public function setMaxOptionsLimit(int $limit): self
    {
        $this->maxOptionsLimit = $limit;
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

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;
        return $this;
    }

    public function isOptional(): bool
    {
        return $this->optional;
    }

    public function setOptional(bool $optional): self
    {
        $this->optional = $optional;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return Collection<int, SurveyQuestionOption>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(SurveyQuestionOption $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
            $option->setQuestion($this);
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
