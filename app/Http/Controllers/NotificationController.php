<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class NotificationController extends Controller
{
    public function index()
    {
    	$return = '';
    	$notifications = Notification::where(array('status'=>1))->get();
    	
    	if(isset($notifications) && $notifications->count() > 0)
    	{
    		foreach ($notifications as $notification) 
    		{
    			$return .= '<a class="dropdown-item font-weight-bold" href="#">'.$notification['message'].'</a>';
    		}

    		$return .= '<a class="dropdown-item text-right small" href="'.route("markallasread").'">Mark All As Read</a>';
    	}
    	else
    	{
    		$return .= '<a class="dropdown-item" href="#">No notifications found</a>';
    	}
    	
    	echo $return;
    }

    public function markAllAsRead(Request $request)
    {
    	$update = Notification::where(array('status'=>1))->update(array('status'=>2));

    	if($update)
    	{
    		return redirect()->back()->with('success','All messages are marked as read');
    	}
    	else
    	{
    		return redirect()->back()->with('error','Oops something went wrong');
    	}
    }
}
