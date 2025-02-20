<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use App\Traits\ApiResponder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\tasks\TaskResource;
use App\Http\Requests\tasks\StoreTaskRequest;
use App\Http\Requests\tasks\UpdateTaskRequest;

class TaskController extends Controller
{
    use ApiResponder;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return $this->success(TaskResource::collection($tasks));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->user_id = Auth::id();
        $task->status = 'pending';
        $task->save();
        return $this->created(new TaskResource($task),"Task Created Successfully");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        if ($request->has('title')) {
            $task->title = $request->title;
        }
        if ($request->has('status')) {
            $task->status = $request->status;
        }
        $task->user_id = Auth::id();
        $task->save();
        return $this->success(new TaskResource($task),"Task Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->success(new TaskResource($task), "Task Deleted Successfully");
    }
}
