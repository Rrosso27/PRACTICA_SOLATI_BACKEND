<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TasksRequest;
use App\Service\Api\TasksService;
use App\Return\ReturnFormat;

class TasksController extends Controller
{
    protected $tasksService;
    protected $returnFormat;

    public function __construct(TasksService $tasksService, ReturnFormat $returnFormat)
    {
        $this->tasksService = $tasksService;
        $this->returnFormat = $returnFormat;
    }
    /**
     * lista de tareas.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $tasks = $this->tasksService->getAllTasks();
            return $this->returnFormat->success($tasks, 'Tasks retrieved successfully');
        } catch (\Exception $e) {
            return $this->returnFormat->error('Error retrieving tasks: ' . $e->getMessage(), 500);
        }
    }
    /**
     * crear nuevas tareas.
     * @param  App\Http\Requests\TasksRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function store(TasksRequest $request)
    {
        try {
            $task = $this->tasksService->createTask($request->validated());
            return $this->returnFormat->success($task, 'Task created successfully', 201);
        } catch (\Exception $e) {
            return $this->returnFormat->error('Error creating task: ' . $e->getMessage(), 500);
        }
    }
    /**
     * buscar una tarea por Id
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $task = $this->tasksService->getTaskById($id);
            if (!$task) {
                return $this->returnFormat->error('Task not found', 404);
            }
            return $this->returnFormat->success($task, 'Task retrieved successfully');
        } catch (\Exception $e) {
            return $this->returnFormat->error('Error retrieving task: ' . $e->getMessage(), 500);
        }
    }
    /**
     * actualizar una tarea existente.
     * @param  App\Http\Requests\TasksRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TasksRequest $request, $id)
    {
        try {
            $task = $this->tasksService->updateTask($id, $request->validated());
            if (!$task) {
                return $this->returnFormat->error('Task not found', 404);
            }
            return $this->returnFormat->success($task, 'Task updated successfully');
        } catch (\Exception $e) {
            return $this->returnFormat->error('Error updating task: ' . $e->getMessage(), 500);
        }
    }
    /**
     * Eliminar una tarea
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $result = $this->tasksService->deleteTask($id);
            if (!$result) {
                return $this->returnFormat->error('Task not found', 404);
            }
            return $this->returnFormat->success(null, 'Task deleted successfully');
        } catch (\Exception $e) {
            return $this->returnFormat->error('Error deleting task: ' . $e->getMessage(), 500);
        }
    }
}
