<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                <h3 class="card-title">Users list</h3>
            </div>
            <!-- /.card-header -->
            <?php if(session('success')): ?>
                <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger" role="alert"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Is Verified</th>
                            <th style="width: 100px">Role</th>
                            <th style="width: 40px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td>
                                    <?php if($user->email_verified_at): ?>
                                        <span class="badge bg-primary">Verified</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Unverified</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($user->role === \App\Models\User::ROLE_ADMIN ? 'Admin' : 'User'); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-primary"
                                                type="button"
                                                data-user="<?php echo e(json_encode($user)); ?>"
                                                data-toggle="modal"
                                                data-target="#userEditModal">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-default"
                                                type="button"
                                                data-user="<?php echo e(json_encode($user)); ?>"
                                                data-toggle="modal"
                                                data-target="#userEditModalAjax">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger"
                                                type="button"
                                                data-user="<?php echo e(json_encode($user)); ?>"
                                                data-toggle="modal"
                                                data-target="#userDeleteModal">
                                            <i class="fas fa-trash"></i></button>
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
                    <?php if($users->currentPage() > 1): ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($users->previousPageUrl()); ?>">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="<?php echo e($users->url(1)); ?>">1</a></li>
                    <?php endif; ?>

                    <?php if($users->currentPage() > 3): ?>
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    <?php endif; ?>
                    <?php if($users->currentPage() >= 3): ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($users->url($users->currentPage() - 1)); ?>"><?php echo e($users->currentPage() - 1); ?></a></li>
                    <?php endif; ?>

                    <li class="page-item"><span class="page-link page-active"><?php echo e($users->currentPage()); ?></span></li>

                    <?php if($users->currentPage() <= $users->lastPage() - 2): ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($users->url($users->currentPage() + 1)); ?>"><?php echo e($users->currentPage() + 1); ?></a></li>
                    <?php endif; ?>

                    <?php if($users->currentPage() < $users->lastPage() - 2): ?>
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    <?php endif; ?>

                    <?php if($users->currentPage() < $users->lastPage() ): ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($users->url($users->lastPage())); ?>"><?php echo e($users->lastPage()); ?></a></li>
                        <li class="page-item"><a class="page-link" href="<?php echo e($users->nextPageUrl()); ?>">&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- /.card -->

        <div class="modal fade" id="userEditModal">
            <div class="modal-dialog">
                <form action="<?php echo e(route('users.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit user</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="userEditName"></div>
                            <input type="hidden" name="id" id="userEditId" value="" />
                            <div class="form-group">
                                <label for="userEditRole">Role</label>
                                <select class="custom-select rounded-0" name="role" id="userEditRole">
                                    <option value="<?php echo e(\App\Models\User::ROLE_USER); ?>">User</option>
                                    <option value="<?php echo e(\App\Models\User::ROLE_ADMIN); ?>">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="userEditModalAjax">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit user</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="userEditAlert"></div>
                        <div id="userEditNameAjax"></div>
                        <input type="hidden" id="userEditIdAjax" value="" />
                        <div class="form-group">
                            <label for="userEditRoleAjax">Role</label>
                            <select class="custom-select rounded-0" id="userEditRoleAjax">
                                <option value="<?php echo e(\App\Models\User::ROLE_USER); ?>">User</option>
                                <option value="<?php echo e(\App\Models\User::ROLE_ADMIN); ?>">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="userEditButtonAjax">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="userDeleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete user</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="userDeleteAlert"></div>
                        <input type="hidden" id="userDeleteId" value="" />
                        <p>Are you sure you want to delete: <span id="userDeleteName"></span>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="userDeleteButton">Delete</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Practica\resources\views/users/index.blade.php ENDPATH**/ ?>