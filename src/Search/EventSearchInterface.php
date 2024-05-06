<?php

namespace App\Search;

interface EventSearchInterface
{
    public function searchByName(?string $name = null): array;
}
