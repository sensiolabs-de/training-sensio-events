<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public const SF_LIVE = 'sf_live_';

    public function load(ObjectManager $manager): void
    {
        for ($i = 15; $i <= 25; $i++) {
            $year = '20'.$i;
            $event = (new Event())
                ->setName('SymfonyLive '.$year)
                ->setDescription('Share your best practices, experience and knowledge with Symfony.')
                ->setAccessible(true)
                ->setStartAt(new \DateTimeImmutable('28-03-'.$year))
                ->setEndAt(new \DateTimeImmutable('29-03-'.$year))
            ;
            $manager->persist($event);
            $manager->flush();
            $this->addReference(self::SF_LIVE.$i, $event);
        }

    }
}
