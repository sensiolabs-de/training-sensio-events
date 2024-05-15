<?php

namespace App\EventListener;

use App\Entity\Event;
use App\Entity\Organization;
use App\Parser\ApiResultParser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::VIEW)]
final class ApiTransformerListener
{
    public function __construct(
        protected readonly EntityManagerInterface $manager,
        protected readonly ApiResultParser $parser,
    ) {
    }

    public function __invoke(ViewEvent $event): void
    {
        $request = $event->getRequest();
        if ('app_event_search' !== $request->attributes->get('_route')) {
            return;
        }

        $result = $event->getControllerResult();
        $result['events'] = $this->parser->parseResults($result['events']);

        $event->setControllerResult($result);
    }
}
