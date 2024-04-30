<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public const SFLIVE_PROJECT = 'sflive_project';

    public function load(ObjectManager $manager): void
    {
        $project = (new Project())
            ->setName('SymfonyLive')
            ->setSummary('Ongoing effort for the SymfonyLive events organization every year.')
            ->setCreatedAt(new \DateTimeImmutable('01-01-2000'));

        for ($i = 15; $i <= 25; $i++) {
            $project->addEvent($this->getReference(EventFixtures::SF_LIVE.$i));
        }

        $manager->persist($project);
        $manager->flush();
        $this->addReference(self::SFLIVE_PROJECT, $project);
    }

    public function getDependencies()
    {
        return [
            EventFixtures::class,
        ];
    }
}
