<?php

namespace App\Search;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[AsDecorator(EventSearchInterface::class)]
class CacheableEventSearch implements EventSearchInterface
{
    public function __construct(
        private readonly EventSearchInterface $inner,
        private readonly CacheInterface $cache,
    ){
    }

    public function searchByName(?string $name = null): array
    {
        return $this->cache->get(md5($name), function (ItemInterface $item) use ($name) {
            $item->expiresAfter(3600);

            return $this->inner->searchByName($name);
        });
    }
}
