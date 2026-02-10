<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;

class JsonLoginAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        return $request->getPathInfo() === '/login'
            && $request->isMethod('POST')
            && $request->getContentTypeFormat() === 'json';
    }

    public function authenticate(Request $request): Passport
    {
        $data = json_decode($request->getContent(), true);

        return new Passport(
            new UserBadge($data['email'] ?? ''),
            new PasswordCredentials($data['password'] ?? ''),
            [
                new CsrfTokenBadge('authenticate', $data['_csrf_token'] ?? ''),
            ]
        );
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): ?JsonResponse {
        return new JsonResponse([
            'status' => true,
            'user' => $token->getUser()->getUserIdentifier(),
        ]);
    }

    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ): JsonResponse {
        return new JsonResponse([
            'error' => 'Invalid credentials',
        ], 401);
    }
}
