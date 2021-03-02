<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserTask;
use App\TasksAllocation;
use App\Notification;

class TaskEnquiryController extends Controller
{
    public function index()
    {
        $task_details = User::where('user_type',3)->with('tasks','state','city')->get();

        $job_assistance_lists = User::where('user_type',2)->get();
        
        if(isset($job_assistance_lists) && $job_assistance_lists->count() > 0)
        {
            foreach($job_assistance_lists as $assistance_lists)
            {
                $job_assistance[$assistance_lists->id] = $assistance_lists->name;
            }
        }

        $task_allocation_status = array();
        $task_allocated_user = array();
        $taskss_list = array();

        $tasks_count = TasksAllocation::get()->toArray();
        
        if(isset($tasks_count) && !empty($tasks_count))
        {
            foreach($tasks_count as $tasks)
            {
                $task_allocation_status[$tasks['task_id']] = $tasks['status'];
                $task_allocated_user[$tasks['task_id']] = $job_assistance[$tasks['user_id']];
                $taskss_list[] = $tasks['task_id'];
            }
        }
        
        return view('task_enquiries',compact('task_details','tasks_count','job_assistance_lists','taskss_list','task_allocation_status','task_allocated_user'));
    }

    public function assignUser(Request $request)
    {
    	$validatedData = $request->validate([
           	'user_id' => ['required'],
            'task_id' => ['required'],
        ]);

    	$validatedData['status'] = 1;
    	$task_upd['status'] = 1;
    	$update_task = UserTask::where('id',$request->task_id)->update($task_upd);
        
        TasksAllocation::create($validatedData);

        $notification_arr['message'] = '#'.$request->task_i.' Task is assigend';
        $notification_arr['status'] = 1;

        Notification::create($notification_arr);

        return redirect()->back()->with('success','User allocated successfully');
    }

    public function ReassignUser(Request $request)
    {
        $validatedData = $request->validate([
            'reassign_user_id' => ['required'],
            'reassign_task_id' => ['required'],
        ]);

        $check_older_allocation = TasksAllocation::where('task_id',$request->reassign_task_id)->where('user_id','!=',$request->reassign_user_id)->get();

        if($check_older_allocation->count() > 0)
        {
            $update_allocation = TasksAllocation::where('task_id',$request->reassign_task_id)->where('user_id','!=',$request->reassign_user_id)->update(array('status'=>0));
        }

        $validatedData['status'] = 1;
        $task_upd['status'] = 1;
        $update_task = UserTask::where('id',$request->reassign_task_id)->update($task_upd);
        
        $validatedData['user_id'] = $validatedData['reassign_user_id'];
        $validatedData['task_id'] = $validatedData['reassign_task_id'];

        TasksAllocation::create($validatedData);

        $notification_arr['message'] = '#'.$request->reassign_task_id.' Task is reassigend';
        $notification_arr['status'] = 1;

        Notification::create($notification_arr);

        return redirect()->back()->with('success','User reallocated successfully');
    }
}
