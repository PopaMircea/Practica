<?php $__env->startSection('body'); ?>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?php echo e(route('dashboard')); ?>"><b>Admin</b> LTE</a>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form action="" method="post">
                        <?php echo csrf_field(); ?>

                        <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert"><?php echo e(session('status')); ?></div>
                        <?php endif; ?>

                        <?php if($errors->has('login')): ?>
                            <div class="alert alert-danger"><?php echo e($errors->first('login')); ?></div> <?php endif; ?>

                        <?php if($errors->has('email')): ?>
                            <div class="alert alert-danger"><?php echo e($errors->first('email')); ?></div> <?php endif; ?>

                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control <?php if($errors->has('email')): ?> is-invalid <?php endif; ?>" placeholder="Email" value="<?php echo e(old('email')); ?>" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <?php if($errors->has('password')): ?>
                            <div class="alert alert-danger"><?php echo e($errors->first('password')); ?></div> <?php endif; ?>
                        <div class="input-group mb-3">
                            <input name="password" type="password" class="form-control <?php if($errors->has('password')): ?> is-invalid <?php endif; ?>" placeholder="Password" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input name="remember" type="checkbox" id="remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                        </div>
                    </form>

                    <div class="social-auth-links text-center mb-3">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                        </a>
                    </div>

                    <p class="mb-1">
                        <a href="<?php echo e(route('password.email')); ?>">I forgot my password</a>
                    </p>
                    <p class="mb-0">
                        <a href="<?php echo e(route('register')); ?>" class="text-center">Register a new membership</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Practica\resources\views/auth/login.blade.php ENDPATH**/ ?>