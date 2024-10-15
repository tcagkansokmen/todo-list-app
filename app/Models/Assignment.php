<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    protected $fillable = ['task_id', 'developer_id', 'status', 'estimated_completion_time'];

    /**
     * Get the task that owns the assignment.
     *
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the developer that owns the assignment.
     *
     * @return BelongsTo
     */
    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }
}

