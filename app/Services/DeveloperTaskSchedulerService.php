<?php

namespace App\Services;

use App\Models\Developer;
use App\Models\Task;
use App\Repositories\AssignmentRepository;
use Exception;
use Illuminate\Support\Collection;
use stdClass;

class DeveloperTaskSchedulerService
{
    public function __construct(protected AssignmentRepository $assignmentRepository)
    {
        //
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function assignTasksToDevelopers(): void
    {
        $developers = Developer::all()->map(function ($developer) {
            $developer->total_hours = 0;
            return $developer;
        });

        $tasks = Task::orderBy('difficulty', 'desc')
            ->orderBy('duration', 'desc')
            ->get();

        foreach ($tasks as $task) {
            $developer = $this->findDeveloperWithLowestLoad($developers, $task);

            if ($developer) {
                $estimatedHours = ceil(($task->duration * $task->difficulty) / $developer->capacity);

                $this->assignmentRepository->createAssignment($developer->id, $task->id, $estimatedHours);

                $developer->total_hours += $estimatedHours;
            } else {
                throw new Exception('No available developer with enough capacity!');
            }
        }
    }

    /**
     * Find the developer with the lowest load
     *
     * @param Collection $developers
     * @param Task $task
     * @return Developer|stdClass|null
     * @throws Exception
     */
    private function findDeveloperWithLowestLoad(Collection $developers, Task $task): Developer|stdClass|null
    {
        $bestDeveloper = null;
        $minTotalHours = 99;

        foreach ($developers as $developer) {
            $estimatedHours = ceil(($task->duration * $task->difficulty) / $developer->capacity);

            if ($developer->total_hours + $estimatedHours <= 45 && $developer->total_hours < $minTotalHours) {
                $minTotalHours = $developer->total_hours;
                $bestDeveloper = $developer;
            }
        }

        return $bestDeveloper;
    }
}
