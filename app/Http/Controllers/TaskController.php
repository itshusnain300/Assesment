<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $data['tasks'] = Task::query()
                ->when($request->status, fn($query, $status) => $query->where('status', $status))
                ->when($request->due_date, fn($query, $date) => $query->whereDate('due_date', $date))
                ->get();

            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json($data['tasks'], Response::HTTP_OK);
            }
            return view('index', $data);
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json(['error' => 'Failed to fetch tasks'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return redirect()->back()->with('error', 'Failed to fetch tasks');
        }
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            $task = Task::create($request->validated());

            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'message' => 'Task created successfully.',
                    'task' => $task
                ], Response::HTTP_CREATED);
            }

            return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json(['error' => 'Failed to create task'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return redirect()->back()->with('error', 'Failed to create task.');
        }
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task, Request $request)
    {
        try {
            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json($task, Response::HTTP_OK);
            }

            return view('tasks.show', compact('task'));
        } catch (ModelNotFoundException $e) {
            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
            }

            return redirect()->route('tasks.index')->with('error', 'Task not found.');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json(['error' => 'Failed to fetch task'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return redirect()->back()->with('error', 'Failed to fetch task.');
        }
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $data['task'] = $task;
        return view('edit', $data);
    }

    /**
     * Update the specified task in storage.
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        try {
            $task->update($request->validated());

            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'message' => 'Task updated successfully.',
                    'task' => $task
                ], Response::HTTP_OK);
            }

            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json(['error' => 'Failed to update task'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return redirect()->back()->with('error', 'Failed to update task.');
        }
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task, Request $request)
    {
        try {
            $task->delete();

            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json(['message' => 'Task deleted successfully.'], Response::HTTP_NO_CONTENT);
            }

            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                return response()->json(['error' => 'Failed to delete task'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return redirect()->back()->with('error', 'Failed to delete task.');
        }
    }
}
