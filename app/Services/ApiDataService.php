<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\ApiDataRepositoryInterface;
use App\Repositories\BaseApiDataRepository;

class ApiDataService
{
    public function __construct(protected ApiDataRepositoryInterface $repository)
    {
        //
    }

    /**
     * Fetch and store data from multiple APIs
     *
     * @return void
     */
    public function fetchAndStoreData(): void
    {
        $apis = config('api.list');

        foreach ($apis as $apiConfig) {
            $data = (new BaseApiDataRepository())->fetchData($apiConfig['url']);

            foreach ($data as $item) {
                $dtoClass = $apiConfig['dto'];
                $dto = $dtoClass::transform($item);
                $this->storeData($dto);
            }
        }
    }

    /**
     * Store data to the database
     *
     * @param mixed $dto
     * @return void
     */
    protected function storeData(mixed $dto): void
    {
        Task::create(
            ['name' => $dto->name, 'difficulty' => $dto->difficulty, 'duration' => $dto->duration]
        );
    }
}
