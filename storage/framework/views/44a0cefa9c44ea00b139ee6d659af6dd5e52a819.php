


<!-- yield from app-base.blade.php -->
<?php $__env->startSection('css-styles'); ?>
    <?php echo $__env->yieldContent('user-css-styles'); ?>
<?php $__env->stopSection(); ?>

<!-- yield from app-base.blade.php -->
<?php $__env->startSection('js-scripts'); ?>
    <?php echo $__env->yieldContent('user-js-scripts'); ?>
<?php $__env->stopSection(); ?>

<!-- yield from app-base.blade.php -->
<?php $__env->startSection('navbar'); ?>
    <li><a href="<?php echo e(route('home-page')); ?>">Home</a></li>  
    <li><a href="<?php echo e(route('read-posts')); ?>">Read Posts</a></li>
    <?php echo $__env->make('components.navbar-user-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/user/user-master.blade.php ENDPATH**/ ?>