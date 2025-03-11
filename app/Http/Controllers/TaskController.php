<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()) {

            $tasks = Task::get();
            return DataTables::of($tasks)
                ->addColumn('actions', function ($task) {
                    return '<button class="btn btn-danger delete-task" data-id="' . $task->id . '">حذف</button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return  view("tasks.index");
    }
    //
}
