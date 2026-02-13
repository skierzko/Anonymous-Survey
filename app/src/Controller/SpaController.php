<?php

namespace App\Controller;

use App\Entity\User;
use App\Utils\ViteAsset;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SpaController extends AbstractController
{
    public function index(
        CsrfTokenManagerInterface $csrfTokenManager,
        ViteAsset $viteAsset,
        ): Response
    {
        $token = $csrfTokenManager->getToken('registration')->getValue();
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('spa.html.twig', [
            'vite_asset' => $viteAsset,
            'props' => [
                'csrfToken' => $token,
                'userLogged' => $user?->toArray(),
            ]
        ]);
    }
}