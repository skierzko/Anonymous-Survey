<?php

namespace App\Entity;

use App\Repository\SurveyQuestionOptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SurveyQuestionOptionRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'survey_question_options')]
class SurveyQuestionOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'options')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SurveyQuestion $question = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read'])]
    private string $title;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private bool $visible = true;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $position = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['user:read'])]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['user:read'])]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Groups(['user:read'])]
    private ?\DateTimeImmutable $deletedAt = null;

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

    public function setQuestion(?SurveyQuestion $question): self
    {
        $this->question = $question;
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;
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
