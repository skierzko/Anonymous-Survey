<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SpaController extends AbstractController
{
    public function index(CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $token = $csrfTokenManager->getToken('registration')->getValue();

        return $this->render('spa.html.twig', [
            'props' => [
                'csrfToken' => $token,
            ]
        ]);
    }
}