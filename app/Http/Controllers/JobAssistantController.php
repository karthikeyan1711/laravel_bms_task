<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserTask;
use App\TasksAllocation;
use App\Notification;

class JobAssistantController extends Controller
{
   public function index()
   {
	 	$task_details = User::where('user_type',3)->with('tasks','state','city')->get();
	 	$my_tasks = TasksAllocation::where('user_id',Auth()->user()->id)->where('status','!=',0)->get()->toArray();
    	$task_allocation_status = array();
    	$my_tasks_list = array();
    	
    	if(isset($my_tasks) && !empty($my_tasks))
    	{
    		foreach($my_tasks as $my_task)
    		{
    			$task_allocation_status[$my_task['task_id']] = $my_task['status'];
    			$my_tasks_list[] = $my_task['task_id'];
    		}
    	}
    	return view('job_assistance_task_enquiries',compact('task_details','my_tasks_list','task_allocation_status'));
   }

   public function RejectTask(Request $request,$task_id)
    {
        $check_allocation = TasksAllocation::where('task_id',$task_id)->where('user_id','=',Auth()->user()->id)->get();

        if($check_allocation->count() > 0)
        {
            $update_allocation = TasksAllocation::where('task_id',$task_id)->where('user_id','=',Auth()->user()->id)->update(array('status'=>0));
            $update_task = UserTask::where('id',$task_id)->update(array('status'=>0));
        }

        $notification_arr['message'] = Auth()->user()->name.' Rejected #'.$task_id.' the task';
        $notification_arr['status'] = 1;

        Notification::create($notification_arr);

        return redirect()->back()->with('success','Task updated successfully');
    }

    public function AcceptTask(Request $request,$task_id)
    {
        $check_allocation = TasksAllocation::where('task_id',$task_id)->where('user_id','=',Auth()->user()->id)->get();

        if($check_allocation->count() > 0)
        {
            $update_allocation = TasksAllocation::where('task_id',$task_id)->update(array('status'=>2));
        }

        $notification_arr['message'] = Auth()->user()->name.' Accpted #'.$task_id.' the task';
        $notification_arr['status'] = 1;

        Notification::create($notification_arr);

        return redirect()->back()->with('success','Task updated successfully');
    }
}
