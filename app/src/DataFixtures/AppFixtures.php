<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\ApiTokenFactory;
use App\Factory\TaskFactory;
use App\Factory\UserFactory;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const TEST_USER_EMAIL = 'test@user.email';
    private const TEST_USER_PASS = '123';

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail(self::TEST_USER_EMAIL);
        $tmpPwd = $this->passwordHasher->hashPassword($user, self::TEST_USER_PASS);
        $user->setPassword($tmpPwd);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
        $manager->persist($user);

        UserFactory::createMany(10);
        TaskFactory::createMany(10);
        TaskFactory::createMany(10, function () {
            return [
                'owner' => UserFactory::random(),
                'parent' => TaskFactory::random(),
            ];
        });
        ApiTokenFactory::createOne(
            [
                'ownedBy' => $user,
                'expiresAt' => Carbon::now()->addDays(5)->toDateTimeImmutable(),
            ]
        );
        $manager->flush();
    }
}
