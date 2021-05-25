<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Scripts -->
        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

        <!-- Styles -->
        <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    </head>

    <?php echo $__env->yieldContent('body'); ?>

</html>
<?php /**PATH C:\xampp\htdocs\Practica\resources\views/layout/base.blade.php ENDPATH**/ ?>