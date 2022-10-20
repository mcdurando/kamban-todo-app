<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Task;
use Validator;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class TaskController extends BaseController
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
    
        return $this->sendResponse(TaskResource::collection($tasks), 'Tasks retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'task_name' => 'required',
            'description' => '',
            'status' => 'required',
            'duration' => '',
            'priority' => '',
            'assignee' => ''
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $task = Task::create($input);
   
        return $this->sendResponse(new TaskResource($task), 'Task created successfully.');
    } 

    // Get all task with specific user id
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
        $task = Task::find($id);
  
        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }
        */
        $task = Task::where('assignee', $id)->get();
   
        return $this->sendResponse($task, 'Task retrieved successfully.');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Task $task)
    public function update($id, Request $request)
    {
        /*
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'task_name' => 'required',
            'description' => '',
            'status' => 'required',
            'duration' => '',
            'priority' => '',
            'assignee' => ''
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $task->task_name = $input['task_name'];
        $task->description = $input['description'];
        $task->status = $input['status'];
        $task->duration = $input['duration'];
        $task->priority = $input['priority'];
        $task->assignee = $input['assignee'];

        $task->save();
        */
        $task = Task::find($id);
        $task->update($request->all());
   
        return $this->sendResponse(new TaskResource($task), 'Task updated successfully.');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
   
        return $this->sendResponse([], 'Task deleted successfully.');
    }

    // Custom resource

    public function updateAllTasks(Request $request){

        $allTasksUpdated = $request->all();

        foreach($allTasksUpdated as $item){

            Task::where('id', '=', $item['id'])
            ->update([
                'task_name' => $item["task_name"],
                'description' => $item["description"], 
                'status' => $item["status"] ,  
                'duration' => $item["duration"] , 
                'priority' =>  $item["priority"] ,
                'assignee' =>  $item["assignee"] 
            ]);

        }

        return $this->sendResponse([], 'All Tasks updated successfully.');
    }
   
}
