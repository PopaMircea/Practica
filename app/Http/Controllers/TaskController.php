<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    public function updateTask(Request $request, $id): JsonResponse{
        
       $task= Task::find($id);

       $error = '';
       $success = '';
       if($task){
       $task->name = $request->name;
       if($request->descripiton != NULL){
       $task->description = $request->description;
       }else{
           $task->description = $request->get('description');
       }
       $task->assignment = $request->assignment;
       $task->status = $request->status;
       $task->save();
       
       $success = 'Task saved';  
    }  else {
        $error = 'User not found!';
    }
           
       return response()->json(['error' => $error, 'success' => $success, 'task' => $task]);
    }

    public function deleteTask(Request $request, $id): JsonResponse
    {
        $task = Task::find($id);

        $error = '';
        $success = '';

        if ($task) {
            $task->delete();

            $success = 'Task deleted';
        } else {
            $error = 'Task not found!';
        }

        return response()->json(['error' => $error, 'success' => $success]);
    }
}
