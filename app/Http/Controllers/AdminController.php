<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserTask;
use App\State;
use App\City;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
    	$task_details = User::where('user_type',2)->with('state','city')->get();
        return view('job_assistances',compact('task_details'));
    }

    public function create()
    {
    	$states = State::all();
    	return view('add_job_assistances',compact('states'));
    }

    public function store(Request $request)
    {
    	$validatedData = $request->validate([
            'name' => ['required','min:5','max:100'],
            'email' => ['required', 'unique:users','min:7','max:60'],
            'phone_number' => ['required','min:7','max:15'],
            'state_id' => ['required'],
            'city_id' => ['required'],
            'address' => ['required'],
            'password' => ['required','min:8','max:60'],
        ]);

    	$validatedData['password'] = Hash::make($validatedData['password']);
    	$validatedData['user_type'] = 2;

    	$user_id = User::create($validatedData);

    	return redirect()->back()->with('success','User creted successfully');
    }

    public function edit(Request $request, $id)
    {
    	$user_details = User::where('user_type',2)->where('id',$id)->with('state','city')->get();
    	$states = State::all();
    	$cities = City::where('state_id',$user_details[0]->state_id)->get();
    	return view('edit_job_assistances',compact('states','user_details','cities'));
    }

    public function update(Request $request,$id)
    {
    	$validatedData = $request->validate([
            'name' => ['required','min:5','max:100'],
            'email' => ['required', 'unique:users,email,'.$id,'min:7','max:60'],
            'phone_number' => ['required','min:7','max:15'],
            'state_id' => ['required'],
            'city_id' => ['required'],
            'address' => ['required'],
            'password' => ['nullable','min:8','max:60'],
        ]);

    	$validatedData['password'] = Hash::make($validatedData['password']);

    	if(empty($validatedData['password']))
    	{
    		unset($validatedData['password']);
    	}

    	$user_id = User::where('id',$id)->update($validatedData);
    	return redirect()->back()->with('success','User updated successfully');
    }
}
