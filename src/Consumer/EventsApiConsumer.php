<?php

namespace App\Consumer;

use App\Search\EventSearchInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsAlias]
class EventsApiConsumer implements EventSearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $eventsClient,
    )
    {
    }

    public function searchByName(?string $name = null): array
    {
        $options = [];

        if (null !== $name) {
            $options['query'] = ['name' => $name];
        }

        return $this->eventsClient
            ->request('GET', '/events', $options)
            ->toArray();
    }
}
