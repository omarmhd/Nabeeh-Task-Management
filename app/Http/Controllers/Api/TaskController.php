<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        return response()->json(Task::all());
    }

    public function store(Request $request) {
        $request->validate(['title' => 'required|string', 'status' => 'in:To-Do,In Progress,Done']);
        $task = Task::create($request->only(["title","description","status"]));
        return response()->json($task, 201);
    }

    public function show($id) {

        $task=Task::findOrFail($id);
        try {
            return response()->json([
                'status' => true,
                'data' => $task,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed',
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
        $task = Task::findOrFail($id);
        $request->validate(['title' => 'string', 'status' => 'in:To-Do,In Progress,Done']);
        $task->update($request->only(["title","description","status"]));
        return response()->json([
            "status"=>false,
            "data"=>$task
        ]);
        } catch (\Exception $e) {
            return response()->json([
                "status"=>false,
                'message' => 'Failed'
            ], 500);
        }
    }

    public function destroy($id) {
        try {
        Task::findOrFail($id)->delete();
        return response()->json([
            "status"=>true,
            'message' => 'Task deleted successfully'
        ]);
        } catch (\Exception $e) {
            return response()->json(["status"=>false,'message' => 'Failed'], 500);
        }
    }
}
