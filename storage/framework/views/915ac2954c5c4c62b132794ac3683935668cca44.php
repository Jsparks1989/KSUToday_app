
<!-- ====================================================================================================== -->
<!-- Moderators index view                                                                                -->
<!-- CHILD VIEW of: moderator-master.blade.php                                                            -->

<!-- #header @navbar  includes:                                                                              -->
<!--    1) Home btn(user-index.blade.php)                                                                   -->
<!--    2) Read Posts btn(inc/read-all-posts.blade.php)                                                     -->
<!--    3) Create Posts btn(inc/create-post.blade.php)                                                      -->

<!-- #main includes: Filler text for now                                                                    -->

<!-- #sidebar-right includes:                                      -->
<!--    1) My Posts btn(inc/read-my-posts.blade.php) -->
<!--    2) Approve/Deny/Edit Post btn() -->

<!-- ====================================================================================================== -->





<?php $__env->startSection('main'); ?>
    <h1>Moderator: index page</h1>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('moderator.moderator-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/moderator/moderator-index.blade.php ENDPATH**/ ?>