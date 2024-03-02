<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tasks = Task::all();
        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'status' => 'required|in:nueva,en desarrollo,finalizada',
            'user_story_id' => 'required|exists:user_stories,id',
            'assigned_to' => 'nullable|integer|exists:users,id'
        ]);
         // Obtener el ID del usuario autenticado
    $createdBy = Auth::id();

    // Crear la tarea con el ID del usuario autenticado
    $task = Task::create(array_merge($request->all(), ['updated_by' => $createdBy]));
                $task = Task::create($request->all());
                return response()->json([
                    'success' => true,
                    'message' => 'Tarea creada exitosamente',
                    'data' => $task,
                ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $request->validate([
            'description' => 'string',
            'status' => 'in:nueva,en desarrollo,finalizada',
            'user_story_id' => 'exists:user_stories,id'
        ]);

        $task->update($request->all());
        return response()->json($task, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $task->delete();
        return response()->json(null, 204);
    }
}
