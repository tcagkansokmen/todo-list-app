<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Repositories\AssignmentRepository;
use App\Services\DeveloperTaskSchedulerService;
use Illuminate\Support\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class DeveloperTaskSchedulerServiceTest extends TestCase
{
    protected DeveloperTaskSchedulerService $service;
    protected $assignmentRepository;

    public function test_it_finds_developer_with_lowest_load()
    {
        $developers = new Collection([
            (object)['id' => 1, 'capacity' => 10, 'total_hours' => 5],
            (object)['id' => 2, 'capacity' => 10, 'total_hours' => 2],
        ]);

        $task = new Task(['duration' => 3, 'difficulty' => 2]);

        $developer = $this->invokeMethod($this->service, 'findDeveloperWithLowestLoad', [$developers, $task]);

        $this->assertEquals(2, $developer->id);
    }

    protected function invokeMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function test_it_returns_null_when_no_developer_can_take_task()
    {
        $developers = new Collection([
            (object)['id' => 1, 'capacity' => 10, 'total_hours' => 45],
        ]);

        $task = new Task(['duration' => 5, 'difficulty' => 5]);

        $developer = $this->invokeMethod($this->service, 'findDeveloperWithLowestLoad', [$developers, $task]);

        $this->assertNull($developer);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->assignmentRepository = Mockery::mock(AssignmentRepository::class);
        $this->service = new DeveloperTaskSchedulerService($this->assignmentRepository);
    }
}
