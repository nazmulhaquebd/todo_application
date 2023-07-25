<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos;
        return response()->json($todos);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        $todo = auth()->user()->todos()->create($validatedData);

        return response()->json($todo, 201);
    }

    public function show($id)
    {
        $todo = auth()->user()->todos()->findOrFail($id);
        return response()->json($todo);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        $todo = auth()->user()->todos()->findOrFail($id);
        $todo->update($validatedData);

        return response()->json($todo);
    }

    public function destroy($id)
    {
        $todo = auth()->user()->todos()->findOrFail($id);
        $todo->delete();

        return response()->json(null, 204);
    }
}
