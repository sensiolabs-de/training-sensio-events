<?php

namespace App\Parser;

use App\Entity\Event;
use App\Entity\Organization;
use App\Transformer\ApiToEventTransformer;
use App\Transformer\ApiToOrganizationTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ApiResultParser
{
    protected bool $isOrgOrAdmin = false;
    public function __construct(
        protected readonly EntityManagerInterface $manager,
        protected readonly ApiToEventTransformer $eventTransformer,
        protected readonly ApiToOrganizationTransformer $organizationTransformer,
        protected readonly AuthorizationCheckerInterface $checker
    ) {
        $this->isOrgOrAdmin = $this->checker->isGranted('ROLE_ORGANIZER') || $this->checker->isGranted('ROLE_WEBSITE');
    }

    public function parseResults(array $results): iterable
    {
        return \array_map(function (array $apiEvent) {
            $event = $this->findOrCreateEvent($apiEvent);

            foreach ($apiEvent['organizations'] as $org) {
                $entity = $this->findOrCreateOrganization($org);
                $entity->addEvent($event);
            }

            if ($this->isOrgOrAdmin) {
                $this->manager->flush();
            }

            return $event;
        },$results);
    }

    private function findOrCreateEvent(array $apiEvent): Event
    {
        $event = $this->manager
            ->getRepository(Event::class)
            ->findOneBy([
                'name' => $apiEvent['name'],
                'startAt' => new \DateTimeImmutable($apiEvent['startDate'])
            ]);

        if (null === $event) {
            $event = $this->eventTransformer->transform($apiEvent);

            if ($this->isOrgOrAdmin) {
                $this->manager->persist($event);
            }
        }

        return $event;
    }

    private function findOrCreateOrganization($org): Organization
    {
        $entity = $this->manager->getRepository(Organization::class)->findOneBy(['name' => $org['name']]);

        if (null === $entity) {
            $entity = $this->organizationTransformer->transform($org);

            if ($this->isOrgOrAdmin) {
                $this->manager->persist($entity);
            }
        }

        return $entity;
    }
}
