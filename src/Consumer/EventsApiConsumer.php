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
        return $this->eventsClient->request('GET', 'https://www.devevents-api.fr/api/events', [
            'query' => ['name' => $name],
        ])->toArray();
    }
}
