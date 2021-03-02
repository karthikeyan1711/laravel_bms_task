@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(Auth::check() && Auth::user()->user_type == 1)
                <div class="card">
                    <div class="card-header">{{ __('All Tasks') }}</div>
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
                                            <tr class="{{ ($tasks->tasks[0]->status == 1) ? 'text-success' : 'text-danger' }}">
                                                <td>{{ $tasks->id }}</td>
                                                <td>{{ $tasks->name }}</td>
                                                <td>{{ $tasks->phone_number }}</td>
                                                <td>{{ $tasks->email }}</td>
                                                <td>{{ $tasks->state->name }}</td>
                                                <td>{{ $tasks->city->name }}</td>
                                                <td>{{ $tasks->tasks[0]->task_description }}</td>
                                                <td>
                                                  <?php
                                                    if(isset($task_allocation_status[$tasks->tasks[0]->id]) && $task_allocation_status[$tasks->tasks[0]->id] == 2)
                                                    {
                                                        ?>
                                                        Request Accepted By {{ isset($task_allocated_user[$tasks->tasks[0]->id]) ? $task_allocated_user[$tasks->tasks[0]->id] : '' }}
                                                        
                                                        <?php
                                                    }
                                                    else if($tasks->tasks[0]->status == 1)
                                                    {
                                                      ?>
                                                        Allocated - {{ isset($task_allocated_user[$tasks->tasks[0]->id]) ? $task_allocated_user[$tasks->tasks[0]->id] : '' }}
                                                      <?php
                                                    }
                                                    else if($tasks->tasks[0]->status == 0 || $tasks->tasks[0]->status == 'NUll')
                                                    {
                                                       ?>
                                                       Not Assigned
                                                       <?php
                                                    }
                                                  ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($tasks->tasks[0]->status == 1 || $tasks->tasks[0]->status == 2)
                                                        {
                                                            ?><a href="#" class="btn btn-warning btn-sm" onclick="CallReAssignModal({{ $tasks->tasks[0]->id }});">Reassign User</a><?php
                                                        }
                                                        else if($tasks->tasks[0]->status == 0 || $tasks->tasks[0]->status == 'NUll')
                                                        {
                                                            ?><a href="#" class="btn btn-success btn-sm" onclick="CallAssignModal({{ $tasks->tasks[0]->id }});">Assign User</a><?php
                                                        }
                                                    ?>
                                                </td>
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

<!-- The Modal -->
<div class="modal fade" id="assignModal">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Assign User</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <!-- Modal body -->
    <div class="modal-body">
     <form action="{{ @route('assignUser') }}" method="POST">
        @csrf
         <div class="form-group row justify-content-center">
             <div class="col-md-9">
                 <select class="form-control" id="user_id" name="user_id" required>
                     <option value="">Select Assistance</option>
                     @if(isset($job_assistance_lists) && $job_assistance_lists->count() > 0)
                        @foreach($job_assistance_lists as $job_assistance)
                            <option value="{{ $job_assistance->id }}">{{ $job_assistance->name }}</option>
                        @endforeach
                     @endif
                 </select>
             </div>
         </div>
         <input type="hidden" name="task_id" id="task_id">
         <div class="form-group">
             <div class="col-md-12 text-center">
                <input type="submit" name="submit" class="btn btn-success" value="Assign">
             </div>
         </div>
     </form>     
    </div>
  </div>
</div>
</div>

<!-- The Modal -->
<div class="modal fade" id="ReassignModal">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">ReAssign User</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <!-- Modal body -->
    <div class="modal-body">
     <form action="{{ @route('ReassignUser') }}" method="POST">
        @csrf
         <div class="form-group row justify-content-center">
             <div class="col-md-9">
                 <select class="form-control" id="reassign_user_id" name="reassign_user_id" required>
                     <option value="">Select Assistance</option>
                     @if(isset($job_assistance_lists) && $job_assistance_lists->count() > 0)
                        @foreach($job_assistance_lists as $job_assistance)
                            <option value="{{ $job_assistance->id }}">{{ $job_assistance->name }}</option>
                        @endforeach
                     @endif
                 </select>
             </div>
         </div>
         <input type="hidden" name="reassign_task_id" id="reassign_task_id">
         <div class="form-group">
             <div class="col-md-12 text-center">
                <input type="submit" name="submit" class="btn btn-success" value="Assign">
             </div>
         </div>
     </form>     
    </div>
  </div>
</div>
</div>

@section('script')
    
    <script type="text/javascript">
        function CallAssignModal(TaskID)
        {
            $('#assignModal').modal('show');
            $('#task_id').val(TaskID);
        }

        function CallReAssignModal(TaskID)
        {
            $('#ReassignModal').modal('show');
            $('#reassign_task_id').val(TaskID);
        }
    </script>
    
@endsection