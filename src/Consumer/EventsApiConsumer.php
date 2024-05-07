<?php

namespace App\Consumer;

use App\Search\EventSearchInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class EventsApiConsumer implements EventSearchInterface
{
    public function __construct(
        #[Autowire(param: 'env(EVENTS_API_KEY)')]
        private readonly string $apiKey,
    )
    {
    }

    public function searchByName(?string $name = null): array
    {
        // TODO: Implement searchByName() method.
    }
}
