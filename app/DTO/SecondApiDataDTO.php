<?php

namespace App\DTO;

class SecondApiDataDTO
{
    public function __construct(public string $name, public int $difficulty, public int $duration)
    {
        //
    }

    /**
     * Transform data from the second API
     *
     * @param array $data
     * @return SecondApiDataDTO
     */
    public static function transform(array $data): SecondApiDataDTO
    {
        return new self('mock2-'.$data['id'], $data['zorluk'], $data['sure']);
    }
}
