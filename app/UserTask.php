<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
     protected $fillable = ['user_id','task_description','status'];

     public function tasks()
     {
     	 return $this->belongsTo(User::class);
     }

     public function task_allocation()
     {
     	return $this->belongsTo(TasksAllocation::class,'task_id');
     }
}
