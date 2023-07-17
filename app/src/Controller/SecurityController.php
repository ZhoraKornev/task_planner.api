<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Exception\NotReachedException;
use App\Repository\ApiTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: "app_login", methods: "POST")]
    public function login(ApiTokenRepository $apiTokenRepository, #[CurrentUser] $user = null)
    {
        if (!$this->isGranted('PUBLIC_ACCESS')) {
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type header is "application/json".'
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'tokens' => $this->getUser()->getApiTokens()
        ], Response::HTTP_OK);
    }


    /**
     * @throws NotReachedException
     */
    #[Route(path: '/logout', name: "app_logout")]
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new NotReachedException();
    }
}
