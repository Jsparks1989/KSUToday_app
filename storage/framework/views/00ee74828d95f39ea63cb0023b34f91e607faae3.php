<!-- ====================================================================================================== -->
<!-- PARENT VIEW for MODERATOR after the user logs in and is authenticated as a moderator                                            -->

<!-- Includes: 1) #header @navbar, 2) #main, 3) #sidebar-right, 4) #footer                                                      -->
<!-- The only 3 divs should be altered: 1) #header @navbar, 2) #main @main  and 3) #sidebar-right @sidebar-right                         -->

<!-- ====================================================================================================== -->



<?php $__env->startSection('navbar'); ?>
<button><a href="<?php echo e(route('moderator.index')); ?>">Home</a></button>
<button><a href="<?php echo e(route('moderator.read-posts')); ?>">Read Posts</a></button>
    <button><a href="<?php echo e(route('moderator.create-post')); ?>">Create Post</a></button>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar-right'); ?>
<button><a href="<?php echo e(route('moderator.read-my-posts')); ?>">Read My Posts</a></button>
<button><a href="<?php echo e(route('moderator.moderate-posts')); ?>">Moderate Posts</a></button>
<button><a href="<?php echo e(route('moderator.add-contributors')); ?>">Add Contributors</a></button>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/moderator/moderator-master.blade.php ENDPATH**/ ?>