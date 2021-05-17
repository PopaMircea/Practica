@extends('layout.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Board view</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('boards.all')}}">Boards</a></li>
                        <li class="breadcrumb-item active">Board</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$board->name}}</h3>
            </div>

            <div class="card-body">
                <select class="custom-select rounded-0" id="changeBoard">
                    @foreach($boards as $selectBoard)
                        <option @if ($selectBoard->id === $board->id) selected="selected" @endif value="{{$selectBoard->id}}">{{$selectBoard->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- /.card -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th> Name </th>
                        <th>Description</th>
                        <th>Assignment </th>
                        <th>Status</th>
                        <th>Date of creation</th>
                        <th style="width: 40px">Actions</th>  
                     </tr>
                </thead>
                <tbody>
                    
                    @foreach ($tasks as $task )
                    <tr>
                        
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->description}}</td>
                        @if ($task->assignment != NULL)
                        <td>{{ $task->user->name }}</td>
                        @else <td>No user assigned</td>
                        @endif
                        @if ($task->status === 0)
                        <td>Created</td>
                        @elseif ($task->status === 1)
                         <td>In Progress</td>
                         @elseif ($task->status === 2)
                         <td>Finished</td>
                         @endif
                         <td>{{ $task->created_at }}</td>
                         <td>
                            <div class="btn-group">
                                <button class="btn btn-xs btn-primary"
                                        type="button"
                                        data-task="{{json_encode($task)}}"
                                        data-toggle="modal"
                                        data-target="#taskEditModal">
                                    <i class="fas fa-edit"></i></button>
                                @if ($user->role === App\Models\User::ROLE_ADMIN || $board->user_id === $user->id)   
                                <button class="btn btn-xs btn-danger"
                                        type="button"
                                        data-task="{{json_encode($task)}}"
                                        data-toggle="modal"
                                        data-target="#taskDeleteModal">
                                    <i class="fas fa-trash"></i></button>
                                @endif    
                            </div>
                        </td>
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
        </div>

          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                @if ($tasks->currentPage() > 1)
                    <li class="page-item"><a class="page-link" href="{{$tasks->previousPageUrl()}}">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="{{$tasks->url(1)}}">1</a></li>
                @endif

                @if ($tasks->currentPage() > 3)
                    <li class="page-item"><span class="page-link page-active">...</span></li>
                @endif
                @if ($tasks->currentPage() >= 3)
                    <li class="page-item"><a class="page-link" href="{{$tasks->url($tasks->currentPage() - 1)}}">{{$tasks->currentPage() - 1}}</a></li>
                @endif

                <li class="page-item"><span class="page-link page-active">{{$tasks->currentPage()}}</span></li>

                @if ($tasks->currentPage() <= $tasks->lastPage() - 2)
                    <li class="page-item"><a class="page-link" href="{{$tasks->url($tasks->currentPage() + 1)}}">{{$tasks->currentPage() + 1}}</a></li>
                @endif

                @if ($tasks->currentPage() < $tasks->lastPage() - 2)
                    <li class="page-item"><span class="page-link page-active">...</span></li>
                @endif

                @if ($tasks->currentPage() < $tasks->lastPage() )
                    <li class="page-item"><a class="page-link" href="{{$tasks->url($tasks->lastPage())}}">{{$tasks->lastPage()}}</a></li>
                    <li class="page-item"><a class="page-link" href="{{$tasks->nextPageUrl()}}">&raquo;</a></li>
                @endif
            </ul>
        </div>
    </div>
    <!-- /.card -->
    <div class="modal fade" id="taskEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit task</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="alert alert-danger hidden" id="taskEditAlert"></div>
                <input type="hidden" id="taskId" value="" />  
                <div class="form-group">
                <label for="taskName">Name:</label>   
                <input type="text" id="taskName" value="" /> 
                </div>
                <div class="form-group">
                <label for="taskDescription">Description:</label>  
                <input style="width:100%;" type="text" id="taskDescription" />
                </div>
                <div class="form-group">
                    <label for="taskAssignment">Assignment</label>
                    <select class="form-control select2" id="taskAssignment" style="width: 100%">
                        @foreach ($boardUser as $option )
                            <option value="{{ $option->user_id }}">{{ $option->user->name }}</option>
                        @endforeach
                        <option value="{{ NULL }}"> Unassign user </option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="taskStatus">Status</label>
                  <select class="custom-select rounded-0" id="taskStatus">
                     <option value="{{ \App\Models\Task::STATUS_CREATED }}">Created</option>
                     <option value="{{ \App\Models\Task::STATUS_IN_PROGRESS  }}">In progress</option>
                     <option value="{{ \App\Models\Task::STATUS_DONE }}">Finished</option>    
                  </select>  

                </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="taskEditButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="taskDeleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete task</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger hidden" id="taskDeleteAlert"></div>
                    <input type="hidden" id="taskDeleteId" value="" />
                    <p>Are you sure you want to delete: <span id="taskDeleteName"></span>?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="taskDeleteButton">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    </section>
    <!-- /.content -->
@endsection