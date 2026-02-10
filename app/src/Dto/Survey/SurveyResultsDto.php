<?php

namespace App\Dto\Survey;

use Symfony\Component\Validator\Constraints as Assert;

class SurveyResultsDto
{
    /**
     * @var SurveyAnswerDto[]
     */
    #[Assert\NotBlank]
    #[Assert\All([
        new Assert\Type(SurveyAnswerDto::class)
    ])]
    public array $answers = [];
}
