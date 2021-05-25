@extends('layout.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">


                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ count($users) }}</h3>

                                <p>Users registered</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            @if ($user->role === App\Models\User::ROLE_ADMIN)
                            <a href="{{ route('users.all') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            @else
                            <div class="small-box-footer">No info available <i class="fas fa-ban" style="color: red"></i></div>
                            @endif    
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ count($boards) }}</h3>
                                
                                @if ($user->role === App\Models\User::ROLE_ADMIN)
                                <p>Boards</p>
                                @else
                                <p>Boards where you have acces</p>
                                @endif
                            </div>
                            <div class="icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <a href="{{ route('boards.all') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ count($taskAssigned) }} / {{ count($taskAll) }} </h3>

                                <p>Assigned tasks / Total tasks</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="small-box-footer">No info available <i class="fas fa-ban" style="color: red"></i></div>
                        </div>
                    </div>
                
                </div>


            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection