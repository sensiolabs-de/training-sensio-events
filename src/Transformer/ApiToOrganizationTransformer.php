<?php

namespace App\Transformer;

use App\Entity\Organization;

class ApiToOrganizationTransformer implements ApiToEntityTransformerInterface
{
    public function transform(array $data): Organization
    {
        return (new Organization())
            ->setName($data['name'])
            ->setPresentation($data['presentation'])
            ->setCreatedAt(new \DateTimeImmutable($data['createdAt']));
    }
}
