<?php

namespace App\DTO;

class DeveloperAssignmentDTO
{
    public function __construct(public int $developerId, public array $tasks, public int $totalTime)
    {
        //
    }
}
