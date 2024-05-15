<?php

namespace App\Transformer;

use App\Entity\Event;

class ApiToEventTransformer implements ApiToEntityTransformerInterface
{
    public function transform(array $data): Event
    {
        return (new Event())
            ->setName($data['name'])
            ->setStartAt(new \DateTimeImmutable($data['startDate']))
            ->setEndAt(new \DateTimeImmutable($data['endDate']))
            ->setDescription($data['description'])
            ->setAccessible($data['accessible']);
    }
}
