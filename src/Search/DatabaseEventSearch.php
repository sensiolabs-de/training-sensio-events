<?php

namespace App\Search;

use App\Repository\EventRepository;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

class DatabaseEventSearch implements EventSearchInterface
{
    public function __construct(protected readonly EventRepository $repository)
    {
    }

    public function searchByName(?string $name = null): array
    {
        if (null === $name) {
            return $this->repository->findAll();
        }

        return $this->repository->findLikeName($name);
    }
}
