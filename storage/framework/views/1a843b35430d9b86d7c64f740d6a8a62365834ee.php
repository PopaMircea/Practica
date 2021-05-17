<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Boards</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Boards</li>
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
                <h3 class="card-title">Boards list</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>User</th>
                            <th>Members</th> 
                            <?php if($user->role === App\Models\User::ROLE_ADMIN || $board->user_id === $user->id ): ?>
                                <th style="width: 40px">Actions</th>  
                            <?php endif; ?>
                            
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($board->id); ?></td>
                                <td>
                                    <a href="<?php echo e(route('board.view', ['id' => $board->id])); ?>" class="link"><?php echo e($board->name); ?></a>
                                </td>
                                <td><?php echo e($board->user->name); ?></td>
                                <td>
                                    <?php echo e(count($board->boardUsers)); ?>

                                </td>
                               <?php if($user->role === App\Models\User::ROLE_ADMIN || $board->user_id === $user->id): ?>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-primary"
                                                type="button"
                                                data-board="<?php echo e(json_encode($board)); ?>"
                                                data-toggle="modal"
                                                data-target="#boardEditModal">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger"
                                                type="button"
                                                data-board="<?php echo e(json_encode($board)); ?>"
                                                data-toggle="modal"
                                                data-target="#boardDeleteModal">
                                            <i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <?php if($boards->currentPage() > 1): ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($boards->previousPageUrl()); ?>">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="<?php echo e($boards->url(1)); ?>">1</a></li>
                    <?php endif; ?>

                    <?php if($boards->currentPage() > 3): ?>
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    <?php endif; ?>
                    <?php if($boards->currentPage() >= 3): ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($boards->url($boards->currentPage() - 1)); ?>"><?php echo e($boards->currentPage() - 1); ?></a></li>
                    <?php endif; ?>

                    <li class="page-item"><span class="page-link page-active"><?php echo e($boards->currentPage()); ?></span></li>

                    <?php if($boards->currentPage() <= $boards->lastPage() - 2): ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($boards->url($boards->currentPage() + 1)); ?>"><?php echo e($boards->currentPage() + 1); ?></a></li>
                    <?php endif; ?>

                    <?php if($boards->currentPage() < $boards->lastPage() - 2): ?>
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    <?php endif; ?>

                    <?php if($boards->currentPage() < $boards->lastPage() ): ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($boards->url($boards->lastPage())); ?>"><?php echo e($boards->lastPage()); ?></a></li>
                        <li class="page-item"><a class="page-link" href="<?php echo e($boards->nextPageUrl()); ?>">&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- /.card -->

        <div class="modal fade" id="boardEditModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit board</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="boardEditAlert"></div>
                        <input type="hidden" id="boardEditId" value="" />
                        <div class="form-group">
                            <label for="boardName">Board name</label>
                            <input type="text" id="boardName" />
                        </div>
                        <div class="form-group">
                            <label for="boardAddMembers">Add Members</label>
                            <select  class="form-control select2" name="members[]" id="boardAddMembers" multiple="multiple" style="width: 100%">
                               <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <option value="<?php echo e($member->id); ?>"> <?php echo e($member->name); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="boardEditButton">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="boardDeleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete board</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="boardDeleteAlert"></div>
                        <input type="hidden" id="boardDeleteId" value="" />
                        <p>Are you sure you want to delete: <span id="boardDeleteName"></span>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="boardDeleteButton">Delete</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Practica\resources\views/boards/index.blade.php ENDPATH**/ ?>