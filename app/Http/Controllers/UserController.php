<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserTask;
use App\State;
use App\City;
use App\TasksAllocation;
use App\Notification;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
    	$states = State::all();
    	return view('user.user_registration',compact('states'));
    }

    public function get_city(Request $request)
    {
    	$return = '';
    	$return .= '<option value="">Select City</option>';

    	$get_city_list = City::where('state_id',$request->state_id)->get();

    	if($get_city_list->count() > 0)
    	{
    		foreach($get_city_list as $city_list)
    		{
    			$return .= '<option value="'.$city_list->id.'">'.$city_list->name.'</option>';
    		}
    	}
    	
    	echo $return;
    }

    public function store_registration(Request $request)
    {
    	$validatedData = $request->validate([
            'name' => ['required','min:5','max:100'],
            'email' => ['required', 'unique:users','min:7','max:60'],
            'phone_number' => ['required','min:7','max:15'],
            'state_id' => ['required'],
            'city_id' => ['required'],
            'address' => ['required'],
            'task_description' => ['required'],
        ]);

    	unset($validatedData['task_description']);

    	$validatedData['password'] = Hash::make($validatedData['phone_number']);
    	$validatedData['user_type'] = 3;

    	$user_id = User::create($validatedData)->id;

        $get_assitance = User::where(array('city_id'=>$validatedData['city_id'],'user_type'=>2))->get();

        if(isset($get_assitance) && $get_assitance->count() > 0)
        {
            $UserTask = UserTask::create(array('user_id'=>$user_id,'task_description'=>$request->task_description,'status'=>1))->id;

            foreach($get_assitance as $assitance)
            {
                $TasksAllocation = TasksAllocation::create(array('user_id'=>$assitance->id,'task_id'=>$UserTask,'status'=>1));
            }
        }
        else
        {
            $UserTask = UserTask::create(array('user_id'=>$user_id,'task_description'=>$request->task_description,'status'=>0))->id;

        }

        $notification_arr['message'] = 'New User Added, Task Assigend To Users';
        $notification_arr['status'] = 1;

        Notification::create($notification_arr);

    	return redirect()->back()->with('success','Thankyou for your registration');
    }
}
