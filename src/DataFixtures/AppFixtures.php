<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        protected readonly UserPasswordHasherInterface $hasher,
        #[Autowire(param: 'env(ADMIN_PWD)')]
        protected readonly string $adminPwd,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail('benjamin.zaslavsky@gmail.com')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setPassword($this->hasher->hashPassword($user, $this->adminPwd));

        $manager->persist($user);
        $manager->flush();
    }
}
