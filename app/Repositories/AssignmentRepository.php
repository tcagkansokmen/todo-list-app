<?php

namespace App\Repositories;

use App\Models\Assignment;

class AssignmentRepository
{
    public function createAssignment($developerId, $taskId, $estimatedCompletionTime)
    {
        return Assignment::create([
            'developer_id' => $developerId,
            'task_id' => $taskId,
            'status' => 'pending',
            'estimated_completion_time' => $estimatedCompletionTime,
        ]);
    }
}
