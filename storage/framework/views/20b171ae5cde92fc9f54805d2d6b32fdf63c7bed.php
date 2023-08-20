<!-- ====================================================================================================== -->
<!-- PARENT VIEW for CONTRIBUTOR after the user logs in and is authenticated as a contributor               -->

<!-- Includes: 1) #header @navbar, 2) #main @main, 3) #sidebar-right @sidebar-right, 4)#footer              -->
<!-- The only 3 divs that should be altered are: 1) #header @navbar, 2) #main @main  and 3) #sidebar-right   -->

<!-- ====================================================================================================== -->





<?php $__env->startSection('navbar'); ?>
<button><a href="<?php echo e(route('contributor.index')); ?>">Home</a></button>
<button><a href="<?php echo e(route('contributor.read-posts')); ?>">Read Posts</a></button>
    <button><a href="<?php echo e(route('contributor.create-post')); ?>">Create Post</a></button>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar-right'); ?>
<button><a href="<?php echo e(route('contributor.read-my-posts')); ?>">Read My Posts</a></button>
<button><a href="<?php echo e(route('contributor.post-status')); ?>">Check Posts Status</a></button>
<?php $__env->stopSection(); ?>

  
<?php echo $__env->make('components.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/contributor/contributor-master.blade.php ENDPATH**/ ?>