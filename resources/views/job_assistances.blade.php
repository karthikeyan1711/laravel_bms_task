@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(Auth::check() && Auth::user()->user_type == 1)
                <div class="card">
                    <div class="card-header">{{ __('All Job Assistance') }}</div>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($task_details) && $task_details->count() > 0)
                                        @foreach($task_details as $tasks)
                                            <tr>
                                                <td>{{ $tasks->id }}</td>
                                                <td>{{ $tasks->name }}</td>
                                                <td>{{ $tasks->phone_number }}</td>
                                                <td>{{ $tasks->email }}</td>
                                                <td>{{ $tasks->state->name }}</td>
                                                <td>{{ $tasks->city->name }}</td>
                                                <td class="text-center"><a href="{{ @route('edit-job-assitance',$tasks->id) }}" class="btn btn-warning">Edit</a></td>
                                            </tr>
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
