<?php

namespace App\Http\Controllers;

use App\Models\Assignment;

class AssignmentReportController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['developer', 'task'])->get();
        $totalHours = Assignment::groupBy('developer_id')
            ->selectRaw('developer_id, sum(estimated_completion_time) as total_hours')
            ->orderBy('total_hours', 'desc')->first();

        return view('assignments.index', compact('assignments', 'totalHours'));
    }
}
