
<!-- ====================================================================================================== -->
<!-- Home | Users index view -->
<!-- CHILD VIEW of: user-master.blade.php                                                                   -->

<!-- #header @navbar  includes: 1) Home btn(user-index.blade.php), 2) Read Posts btn(inc/read-all-posts.blade.php)-->
<!-- #main includes: Filler text for now -->
<!-- #sidebar-right includes: Nothing (logout btn is in user-master)                                        -->

<!-- ====================================================================================================== -->













<?php $__env->startSection('main'); ?>
    <h1>Users: index page</h1>

    <p>Display some filler text for now</p>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.user-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/user/user-index.blade.php ENDPATH**/ ?>