<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Developer;
use App\Models\Task;
use App\Repositories\AssignmentRepository;
use App\Services\ApiDataService;
use App\Services\DeveloperTaskSchedulerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class FetchApiDataCommandTest extends TestCase
{
    use RefreshDatabase;

    protected $apiDataService;
    protected $taskSchedulerService;
    protected $assignmentRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(ApiDataService::class, $this->apiDataService);
        $this->app->instance(DeveloperTaskSchedulerService::class, $this->taskSchedulerService);
        $this->app->instance(AssignmentRepository::class, $this->assignmentRepository);
    }

    public function test_it_fetches_data_and_stores_in_database_correctly()
    {
        Developer::factory()->count(3)->create(['capacity' => 10]);

        $this->fakeApiResponses();

        Artisan::call('todo:fetch-data');

        $this->assertDatabaseCount('tasks', 16);
        $this->assertDatabaseCount('assignments', 16);

        $this->assertDatabaseHas('tasks', [
            'id' => 1,
            'duration' => 4,
            'difficulty' => 3,
        ]);

        $this->assertDatabaseHas('assignments', [
            'task_id' => 1,
            'developer_id' => 3,
        ]);
    }

    public function test_it_handles_empty_api_response_gracefully()
    {
        Developer::factory()->count(2)->create(['capacity' => 10]);

        $this->fakeApiResponses(empty: true);

        Artisan::call('todo:fetch-data');

        $this->assertDatabaseCount('tasks', 0);
        $this->assertDatabaseCount('assignments', 0);
    }

    public function test_it_if_no_developers_are_created()
    {
        $this->fakeApiResponses();

        Artisan::call('todo:fetch-data');

        $this->assertDatabaseCount('tasks', 16);
        $this->assertDatabaseCount('assignments', 0);
    }
    public function test_it_handles_incomplete_data_from_apis()
    {
        Developer::factory()->count(2)->create(['capacity' => 10]);

        $incompleteData = [
            ['id' => 1, 'value' => 3, 'estimated_duration' => 4],
            ['id' => 2, 'value' => 3],
            ['id' => 2],
        ];

        Http::fake([
            config('api.list.0.url') => Http::response($incompleteData),
            config('api.list.1.url') => Http::response([]),
        ]);

        Artisan::call('todo:fetch-data');

        $this->assertDatabaseCount('tasks', 1);
    }

    public function test_it_handles_large_number_of_tasks()
    {
        Developer::factory()->count(5)->create(['capacity' => 50]);

        $largeData = array_fill(0, 1000, [
            'id' => rand(1, 1000),
            'value' => rand(1, 10),
            'estimated_duration' => rand(1, 20),
        ]);

        Http::fake([
            config('api.list.0.url') => Http::response($largeData),
            config('api.list.1.url') => Http::response([]),
        ]);

        Artisan::call('todo:fetch-data');

        $this->assertDatabaseCount('tasks', 1000);
    }

    public function test_it_handles_incorrect_data_types()
    {
        Developer::factory()->count(2)->create(['capacity' => 10]);

        $incorrectData = [
            ['id' => 'one', 'value' => 'three', 'estimated_duration' => 'four'],
        ];

        Http::fake([
            config('api.list.0.url') => Http::response($incorrectData),
        ]);

        $this->expectException(\TypeError::class);

        Artisan::call('todo:fetch-data');

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_it_handles_one_api_response_missing()
    {
        Developer::factory()->count(3)->create(['capacity' => 15]);

        Http::fake([
            config('api.list.0.url') => Http::response([
                ['id' => 1, 'value' => 3, 'estimated_duration' => 4],
            ]),
            config('api.list.1.url') => Http::response(null, 500),
        ]);

        Artisan::call('todo:fetch-data');

        $this->assertDatabaseCount('tasks', 1);
    }

    private function fakeApiResponses(bool $empty = false): void
    {
        $fakeResponses = [];

        foreach (config('api.list') as $api) {
            $jsonContent = file_get_contents('tests/Feature/Samples/' . $api['mock']);
            $data = json_decode($jsonContent, true);

            $fakeResponses[$api['url']] = Http::response($empty ? [] : $data);
        }

        Http::fake($fakeResponses);
    }
}
