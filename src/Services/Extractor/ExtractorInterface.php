<?php

namespace App\Services\Extractor;

interface ExtractorInterface
{

    public function extract($file, string $type): \Generator;
}
