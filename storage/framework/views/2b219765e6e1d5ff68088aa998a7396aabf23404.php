<!-- ====================================================================================================== -->
<!-- PARENT VIEW for MODERATOR after the user logs in and is authenticated as a moderator                                            -->

<!-- Includes: 1) #header @navbar, 2) #main, 3) #sidebar-right, 4) #footer                                                      -->
<!-- The only 3 divs should be altered: 1) #header @navbar, 2) #main @main  and 3) #sidebar-right @sidebar-right                         -->

<!-- ====================================================================================================== -->



<?php $__env->startSection('navbar'); ?>
<li><a href="<?php echo e(route('moderator.index')); ?>">Home</a></li>
<li><a href="<?php echo e(route('moderator.read-posts')); ?>">Read Posts</a></li>
    <li><a href="<?php echo e(route('moderator.create-post')); ?>">Create Post</a></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar-right'); ?>
<li><a href="<?php echo e(route('moderator.read-my-posts')); ?>">Read My Posts</a></li>
<li><a href="<?php echo e(route('moderator.moderate-posts')); ?>">Moderate Posts</a></li>
<li><a href="<?php echo e(route('moderator.add-contributors')); ?>">Moderate Contributors</a></li>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/moderator/moderator-master.blade.php ENDPATH**/ ?>