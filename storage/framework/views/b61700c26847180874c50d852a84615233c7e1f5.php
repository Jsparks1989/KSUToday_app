


<?php $__env->startSection('navbar'); ?>


    <button><a href="<?php echo e(route('home')); ?>">Home</a></button>
    


    <button><a href="<?php echo e(route('home.read-posts')); ?>">Read Posts</a></button>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/user/user-master.blade.php ENDPATH**/ ?>