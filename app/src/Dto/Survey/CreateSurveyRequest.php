<?php

namespace App\Dto\Survey;

use Symfony\Component\Validator\Constraints as Assert;

class CreateSurveyRequest
{
    public ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    public string $title;

    public bool $draft = false;

    #[Assert\Length(max: 255)]
    public ?string $slug = null;

    public bool $passwordRequired = false;

    #[Assert\When(
        expression: 'this.passwordRequired == true',
        constraints: [
            new Assert\NotBlank,
            new Assert\Length(min: 6),
        ]
    )]
    public ?string $password = null;

    #[Assert\NotNull]
    #[Assert\Count(min: 1)]
    #[Assert\Valid]
    public array $questions = [];

    #[Assert\Type('array')]
    public array $extraOptions = [];

    public bool $isPublic = false;
}