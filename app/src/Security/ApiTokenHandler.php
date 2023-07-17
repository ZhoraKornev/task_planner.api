<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
class ApiTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private readonly ApiTokenRepository $apiTokens
    ) {
    }

    #[NoReturn] public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        dd($accessToken);
        $accessToken = $this->apiTokens->findOneBy(['token' => $accessToken]);
        if (null === $accessToken || !$accessToken->isValid()) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        return new UserBadge($accessToken->getOwnedBy()->getUserIdentifier());
    }
}