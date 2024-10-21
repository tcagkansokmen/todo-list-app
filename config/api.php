<?php

return [
    'list' => [
        [
            'url' => 'https://raw.githubusercontent.com/WEG-Technology/mock/refs/heads/main/mock-one',
            'dto' => App\DTO\FirstApiDataDTO::class,
            'mock' => 'first_api.json',
        ],
        [
            'url' => 'https://raw.githubusercontent.com/WEG-Technology/mock/refs/heads/main/mock-two',
            'dto' => App\DTO\SecondApiDataDTO::class,
            'mock' => 'second_api.json',
        ],
    ]
];
