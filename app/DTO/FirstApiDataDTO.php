<?php

namespace App\DTO;

class FirstApiDataDTO
{
    public function __construct(public string $name, public int $difficulty, public int $duration)
    {
        //
    }

    /**
     * Transform data from the first API
     *
     * @param array $data
     * @return FirstApiDataDTO
     */
    public static function transform(array $data): FirstApiDataDTO
    {
        return new self('mock1-'.$data['id'], $data['value'], $data['estimated_duration']);
    }
}
