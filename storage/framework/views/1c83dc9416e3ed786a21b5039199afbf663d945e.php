<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Board view</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('boards.all')); ?>">Boards</a></li>
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
                <h3 class="card-title"><?php echo e($board->name); ?></h3>
            </div>

            <div class="card-body">
                <select class="custom-select rounded-0" id="changeBoard">
                    <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selectBoard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php if($selectBoard->id === $board->id): ?> selected="selected" <?php endif; ?> value="<?php echo e($selectBoard->id); ?>"><?php echo e($selectBoard->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    
                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        
                        <td><?php echo e($task->name); ?></td>
                        <td><?php echo e($task->description); ?></td>
                        <?php if($task->assignment != NULL): ?>
                        <td><?php echo e($task->user->name); ?></td>
                        <?php else: ?> <td>No user assigned</td>
                        <?php endif; ?>
                        <?php if($task->status === 0): ?>
                        <td>Created</td>
                        <?php elseif($task->status === 1): ?>
                         <td>In Progress</td>
                         <?php elseif($task->status === 2): ?>
                         <td>Finished</td>
                         <?php endif; ?>
                         <td><?php echo e($task->created_at); ?></td>
                         <td>
                            <div class="btn-group">
                                <button class="btn btn-xs btn-primary"
                                        type="button"
                                        data-task="<?php echo e(json_encode($task)); ?>"
                                        data-toggle="modal"
                                        data-target="#taskEditModal">
                                    <i class="fas fa-edit"></i></button>
                                <?php if($user->role === App\Models\User::ROLE_ADMIN || $board->user_id === $user->id): ?>   
                                <button class="btn btn-xs btn-danger"
                                        type="button"
                                        data-task="<?php echo e(json_encode($task)); ?>"
                                        data-toggle="modal"
                                        data-target="#taskDeleteModal">
                                    <i class="fas fa-trash"></i></button>
                                <?php endif; ?>    
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   
                </tbody>
            </table>
        </div>

          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                <?php if($tasks->currentPage() > 1): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo e($tasks->previousPageUrl()); ?>">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="<?php echo e($tasks->url(1)); ?>">1</a></li>
                <?php endif; ?>

                <?php if($tasks->currentPage() > 3): ?>
                    <li class="page-item"><span class="page-link page-active">...</span></li>
                <?php endif; ?>
                <?php if($tasks->currentPage() >= 3): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo e($tasks->url($tasks->currentPage() - 1)); ?>"><?php echo e($tasks->currentPage() - 1); ?></a></li>
                <?php endif; ?>

                <li class="page-item"><span class="page-link page-active"><?php echo e($tasks->currentPage()); ?></span></li>

                <?php if($tasks->currentPage() <= $tasks->lastPage() - 2): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo e($tasks->url($tasks->currentPage() + 1)); ?>"><?php echo e($tasks->currentPage() + 1); ?></a></li>
                <?php endif; ?>

                <?php if($tasks->currentPage() < $tasks->lastPage() - 2): ?>
                    <li class="page-item"><span class="page-link page-active">...</span></li>
                <?php endif; ?>

                <?php if($tasks->currentPage() < $tasks->lastPage() ): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo e($tasks->url($tasks->lastPage())); ?>"><?php echo e($tasks->lastPage()); ?></a></li>
                    <li class="page-item"><a class="page-link" href="<?php echo e($tasks->nextPageUrl()); ?>">&raquo;</a></li>
                <?php endif; ?>
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
                        <?php $__currentLoopData = $boardUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($option->user_id); ?>"><?php echo e($option->user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e(NULL); ?>"> Unassign user </option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="taskStatus">Status</label>
                  <select class="custom-select rounded-0" id="taskStatus">
                     <option value="<?php echo e(\App\Models\Task::STATUS_CREATED); ?>">Created</option>
                     <option value="<?php echo e(\App\Models\Task::STATUS_IN_PROGRESS); ?>">In progress</option>
                     <option value="<?php echo e(\App\Models\Task::STATUS_DONE); ?>">Finished</option>    
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Practica\resources\views/boards/view.blade.php ENDPATH**/ ?>