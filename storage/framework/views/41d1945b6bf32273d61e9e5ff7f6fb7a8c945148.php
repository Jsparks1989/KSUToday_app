

<?php $__env->startSection('css-styles'); ?>
    <!-- <link href="<?php echo e(asset('css/ksu_css/default.css')); ?>" rel="stylesheet"> -->
    <!-- <link href="<?php echo e(asset('css/ksu_css/default.less')); ?>" rel="stylesheet"> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar'); ?>


    <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
    


    <li><a href="<?php echo e(route('home.read-posts')); ?>">Read Posts</a></li>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/user/user-master.blade.php ENDPATH**/ ?>