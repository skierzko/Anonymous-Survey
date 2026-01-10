<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SpaController extends AbstractController
{
    public function index(CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $token = $csrfTokenManager->getToken('registration')->getValue();
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('spa.html.twig', [
            'props' => [
                'csrfToken' => $token,
                'userLogged' => $user?->toArray(),
            ]
        ]);
    }
}