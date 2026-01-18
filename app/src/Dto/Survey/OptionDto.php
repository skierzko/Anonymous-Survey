<?php

namespace App\Dto\Survey;

use Symfony\Component\Validator\Constraints as Assert;

class OptionDto
{
    public ?int $id = null;
    
    #[Assert\NotBlank]
    public string $title;

    public bool $visible = true;
}