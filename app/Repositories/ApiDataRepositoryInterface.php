<?php

namespace App\Repositories;

interface ApiDataRepositoryInterface
{
    /**
     * Fetch data from the given URL
     *
     * @param string $url
     * @return array
     */
    public function fetchData(string $url): array;
}
