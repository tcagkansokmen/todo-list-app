<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Services\DeveloperTaskSchedulerService;
use Illuminate\Console\Command;
use App\Services\ApiDataService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Command\Command as CommandAlias;

class FetchApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:fetch-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from external APIs and store in the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected ApiDataService $apiDataService, protected DeveloperTaskSchedulerService $taskSchedulerService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Tüm kayıtlar temizleniyor.');

        Task::query()->delete();
        $this->info('Tüm kayıtlar temzilendi.');

        $this->info('API verileri alınıyor.');

        try {
            $this->apiDataService->fetchAndStoreData();
            $this->info('API verileri başarıyla alındı ve veritabanına kaydedildi.');

            $this->info('Tasklar atanıyor.');
            $this->taskSchedulerService->assignTasksToDevelopers();
        } catch (\Exception $e) {
            $this->error('Hata: ' . $e->getMessage());
            return CommandAlias::FAILURE;
        }

        return CommandAlias::SUCCESS;
    }
}
