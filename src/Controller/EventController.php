<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/events', name: 'app_event_list', methods: ['GET'])]
    public function listEvents(EventRepository $repository): Response
    {
        $events = $repository->findAll();

        return $this->render('event/list_events.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/event/{id}', name: 'app_event_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showEvent(Event $event): Response
    {
        return $this->render('event/show_event.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/event/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function newEvent(): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        return new Response('Event created');
    }
}
