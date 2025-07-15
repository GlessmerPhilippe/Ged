<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('philippeglessmer@gmail.com');
        $user->setCivilite('Monsieur');
        $user->setNom('GLESSMER');
        $user->setPrenom('Philippe');
        $user->setNaissanceAt(new \DateTime('1979-04-11'));
        $user->setIsVerified(true);
        $user->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->hasher->hashPassword($user, 'Plg@11041979?!Ged');
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}
