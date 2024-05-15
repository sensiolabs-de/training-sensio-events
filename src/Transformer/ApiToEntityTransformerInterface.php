<?php

namespace App\Transformer;

interface ApiToEntityTransformerInterface
{
    public function transform(array $data): object;
}
