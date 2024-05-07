<?php

namespace App\Consumer;

use App\Search\EventSearchInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpClient\HttpClient;

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
        $client = HttpClient::create();

        return $client->request('GET', 'https://www.devevents-api.fr/api/events', [
            'query' => ['name' => $name],
            'headers' => [
                'apikey' => $this->apiKey,
                'Accept' => 'application/json',
            ],
        ])->toArray();
    }
}
