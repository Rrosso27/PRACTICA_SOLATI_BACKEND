<?php

namespace App\Service\Api;

use App\Models\Task;

class TasksService
{
    /**
     * listar todas las tareas.
     */
    public function getAllTasks()
    {
        return Task::all();
    }
    /**
     * Buscar una tarea por Id
     * @param int $id
     * @return Task|null
     */
    public function getTaskById($id)
    {
        return Task::find($id);
    }
    /**
     * crear una nueva tarea.
     * @param array $data
     * @return Task
     */
    public function createTask(array $data)
    {
        return Task::create($data);
    }
    /**
     * actualizar una tarea existente.
     * @param int $id
     * @param array $data
     * @return Task|null
     */
    public function updateTask($id, array $data)
    {
        $task = Task::find($id);
        if ($task) {
            $task->update($data);
            return $task->fresh(); // Return updated model
        }
        return null;
    }
    /**
     * eliminar una tarea.
     * @param int $id
     * @return bool
     */
    public function deleteTask($id)
    {
        $task = Task::find($id);
        if ($task) {
            return $task->delete();
        }
        return false;
    }
}
