<?php

// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TasksController;

Route::get('version', function () {
    return response()->json(['version' => '1.0.0']);
});

// Tasks routes
Route::apiResource('tasks', TasksController::class);
