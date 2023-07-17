<?php

declare(strict_types=1);

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function supportsClass($class): bool
    {
        return $class === \App\Entity\User::class;
    }


    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->findByAccessToken($identifier);
        if (!$user) {
            throw new UserNotFoundException(sprintf('User with custom field "%s" not found.', $identifier));
        }
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }
}
