<?php

namespace App\Dto\Survey;

use Symfony\Component\Validator\Constraints as Assert;

class SurveyAnswerDto
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public string $uuid;

    #[Assert\NotNull]
    #[Assert\Type(['string', 'array'])]
    public string|array $value;
}
