<?php

namespace App\Consumer;

use App\Search\EventSearchInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EventsApiConsumer implements EventSearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        #[Autowire(param: 'env(EVENTS_API_KEY)')]
        private readonly string $apiKey,
    )
    {
    }

    public function searchByName(?string $name = null): array
    {
        return $this->client->request('GET', 'https://www.devevents-api.fr/api/events', [
            'query' => ['name' => $name],
            'headers' => [
                'apikey' => $this->apiKey,
                'Accept' => 'application/json',
            ],
        ])->toArray();
    }
}
