<?php

namespace App\Consumer;

use App\Search\EventSearchInterface;

class EventsApiConsumer implements EventSearchInterface
{

    public function searchByName(?string $name = null): array
    {
        // TODO: Implement searchByName() method.
    }
}
