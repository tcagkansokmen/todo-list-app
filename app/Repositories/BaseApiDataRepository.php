<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class BaseApiDataRepository implements ApiDataRepositoryInterface
{
    /**
     * Fetch data from the given URL
     *
     * @param string $url
     * @return array
     * @throws InvalidArgumentException
     */
    public function fetchData(string $url): array
    {
        $response = Http::get($url);

        if ($response->failed()) {
            throw new InvalidArgumentException('API request failed with status: ' . $response->status());
        }

        $data = $response->json();

        if (!is_array($data)) {
            throw new InvalidArgumentException('Expected array, but got ' . gettype($data));
        }

        return $data;
    }
}
