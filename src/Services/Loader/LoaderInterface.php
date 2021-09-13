<?php

namespace App\Services\Loader;

interface LoaderInterface
{

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function load(array $data, string $destination);
}
