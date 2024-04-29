<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event/{name}/{start}/{end}',
        name: 'app_event_new',
        requirements: [
            'name' => '(\w|[- ])+',
            'start' => '\d{2}-\d{2}-\d{4}',
            'end' => '\d{2}-\d{2}-\d{4}',
        ]
    )]
    public function newEvent(string $name, string $start, string $end, EntityManagerInterface $manager): Response
    {
        $event = (new Event())
            ->setName($name)
            ->setDescription('Some generic description')
            ->setAccessible(true)
            ->setStartAt(new \DateTimeImmutable($start))
            ->setEndAt(new \DateTimeImmutable($end))
        ;

        $manager->persist($event);
        $manager->flush();

        return new Response('Event created');
    }

    #[Route('/events', name: 'app_event_list', methods: ['GET'])]
    public function listEvents(EventRepository $repository): Response
    {
        $events = [];
        foreach ($repository->findAll() as $event) {
            $events[] = ['id' => $event->getId(), 'name' => $event->getName()];
        }

        return $this->json($events);
    }

    #[Route('/event/{id}', name: 'app_event_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showEvent(Event $event): Response
    {
        return $this->json(['id' => $event->getId(), 'name' => $event->getName()]);
    }
}
