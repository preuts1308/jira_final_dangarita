<?php

namespace App\Http\Controllers;

use App\Models\User_stories;
use App\Http\Requests\StoreUser_storiesRequest;
use App\Http\Requests\UpdateUser_storiesRequest;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class UserStoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($projectId)
    {
        $user = auth()->user();
        $projects = $user->projects;
        $userStories = User_stories::where('project_id', $projectId)->get();
        return response()->json($userStories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $projectId)
    {
        // Verificar el rol del usuario
        $userRole = Auth::user()->role;
        $managerId = Auth::id();
        if ($userRole !== 'gerente') {
            return response()->json(['error' => 'No tienes permisos para crear proyectos. Tu rol es: ' . $userRole], 403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'acceptance_criteria' => 'required|string',
            'status' => 'required|in:nueva,en desarrollo,finalizada',
        ]);

        $userStory = User_stories::create([
            'title' => $request->title,
            'details' => $request->details,
            'acceptance_criteria' => $request->acceptance_criteria,
            'status' => $request->status,
            'project_id' => $projectId,
        ]);

        return response()->json($userStory, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUser_storiesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User_stories $user_stories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User_stories $user_stories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser_storiesRequest $request, User_stories $user_stories)
    {
        $userStory = User_stories::findOrFail($user_stories);

        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'acceptance_criteria' => 'string',
            'status' => 'in:nueva,en desarrollo,finalizada',
        ]);

        $userStory->update($request->all());

        return response()->json($userStory, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_stories $user_stories)
    {
        //
        $userStory = User_stories::findOrFail($user_stories);
        $userStory->delete();
        return response()->json(null, 204);
    }
}
