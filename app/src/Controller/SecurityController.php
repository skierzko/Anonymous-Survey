<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;

class SecurityController
{
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('Logout handled by Symfony.');
    }
}