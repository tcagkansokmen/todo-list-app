<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssignmentReportController;

Route::get('/', [AssignmentReportController::class, 'index'])->name('assignments.index');
