<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserTask;
use App\TasksAllocation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $task_details = User::where('created_at','>=',date('Y-m-d'))->where('user_type',3)->with('tasks','state','city')->get();
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
        return view('home',compact('task_details','task_allocation_status','my_tasks_list'));
    }
}


