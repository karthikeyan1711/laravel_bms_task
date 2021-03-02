<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TasksAllocation extends Model
{
    protected $fillable = ['user_id', 'task_id', 'status'];

    public function task_allocation()
	{
	 	return $this->hasMany(TasksAllocation::class);
	}
}
