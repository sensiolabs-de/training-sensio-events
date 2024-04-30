<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $org = (new Organization())
            ->setName('Symfony')
            ->setCreatedAt(new \DateTimeImmutable('2018'))
            ->setPresentation('Symfony SAS is the company behind Symfony, the PHP Open-Source framework.')
        ;
        for ($i = 15; $i <= 25; $i++) {
            $org->addEvent($this->getReference(EventFixtures::SF_LIVE.$i));
        }
        $org->addProject($this->getReference(ProjectFixtures::SFLIVE_PROJECT));

        $manager->persist($org);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
            ProjectFixtures::class
        ];
    }
}
