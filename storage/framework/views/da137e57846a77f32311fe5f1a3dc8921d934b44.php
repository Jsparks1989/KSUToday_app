<!-- ====================================================================================================== -->
<!-- PARENT VIEW for after the user logs in and is authenticated                                            -->
<!-- Includes: #header, #main, #sidebar-right, #footer                                                      -->
<!-- The only 3 divs that should be altered are: #header, #main and #sidebar-right                          -->
<!-- #header: navbar will have different lis depending on the user's status                             -->
<!-- #main will display different content depending on user's status                                        -->
<!-- #sidebar-right will display different user menu lis/functions depending on user's status           -->
<!-- ====================================================================================================== -->



<?php $__env->startSection('css-styles'); ?>
    <link href="<?php echo e(asset('css/ksu_css/default.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar'); ?>
<li><a href="<?php echo e(route('admin.index')); ?>">Home</a></li>
<li><a href="<?php echo e(route('admin.read-posts')); ?>">Read Posts</a></li>
    <li><a href="<?php echo e(route('admin.create-post')); ?>">Create Post</a></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar-right'); ?>
<li><a href="<?php echo e(route('admin.read-my-posts')); ?>">Read My Posts</a></li>
<li><a href="<?php echo e(route('admin.moderate-posts')); ?>">Moderate Posts</a></li>
<li><a href="<?php echo e(route('admin.moderate-users')); ?>">Moderate Users</a></li>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/admin/admin-master.blade.php ENDPATH**/ ?>