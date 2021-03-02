@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(Auth::check() && Auth::user()->user_type == 2)
                <div class="card">
                    <div class="card-header">{{ __('My Tasks') }}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                           <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Task</th>
                                        <th>Allocation Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($task_details) && $task_details->count() > 0)
                                        @foreach($task_details as $tasks)
                                            @if(in_array($tasks->tasks[0]->id,$my_tasks_list))

                                            <tr class="{{ ($task_allocation_status[$tasks->tasks[0]->id] == 2) ? 'text-success' : 'text-danger' }}">
                                                <td>{{ $tasks->id }}</td>
                                                <td>{{ $tasks->name }}</td>
                                                <td>{{ $tasks->phone_number }}</td>
                                                <td>{{ $tasks->email }}</td>
                                                <td>{{ $tasks->state->name }}</td>
                                                <td>{{ $tasks->city->name }}</td>
                                                <td>{{ $tasks->tasks[0]->task_description }}</td>
                                                <td>{{ ($task_allocation_status[$tasks->tasks[0]->id] == 2) ? 'Accepted' : 'Not Accepted' }}</td>
                                                <td>
                                                    
                                                    <?php

                                                        if($task_allocation_status[$tasks->tasks[0]->id] == 1)
                                                        {
                                                            ?><a href="{{ @route('accept-job-assistan-tasks',$tasks->tasks[0]->id) }}" class="btn btn-success btn-sm">Accept Task Request</a><?php
                                                        }
                                                        else
                                                        {
                                                            ?><a href="{{ @route('reject-job-assistan-tasks',$tasks->tasks[0]->id) }}" class="btn btn-danger btn-sm">Reject Task Request</a><?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection