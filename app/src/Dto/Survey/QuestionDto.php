<?php

namespace App\Dto\Survey;

use Symfony\Component\Validator\Constraints as Assert;

class QuestionDto
{
    public ?int $id = null;
    
    #[Assert\NotBlank]
    public string $type;

    #[Assert\NotBlank]
    public string $title;

    public bool $visible = true;
    public bool $draft = false;
    public bool $required = false;
    public bool $optional = false;

    #[Assert\PositiveOrZero]
    public int $minOptionsLimit = 0;

    #[Assert\Positive]
    public int $maxOptionsLimit = 1;

    #[Assert\Valid]
    public array $options = [];

    #[Assert\Type('array')]
    public array $extraOptions = [];
}