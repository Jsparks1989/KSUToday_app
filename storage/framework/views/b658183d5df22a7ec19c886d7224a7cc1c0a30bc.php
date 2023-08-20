<!-- ====================================================================================================== 
 * PARENT VIEW for MODERATOR after the user logs in and is authenticated as a moderator  

 * Extends from components.app-master

 * each section('') are yielded at components.app-base
 
 * section('css-styles') & section('js-scripts')
    - files that go here will be included on every blade file that extends from 
      moderator.moderator-master
    - yield('moderator-css-styles') & yield('moderator-js-scripts') allows for 
      js & css files to be included only on specific pages
      
 * section('navbar') & section('sidebar-right')
    - includes links only available for moderator

 * Controller - n/a

 * Route - n/a

 * JS file 
    - n/a

 * CSS file
    - 
 ====================================================================================================== -->



<!-- yield from app-base.blade.php -->
<?php $__env->startSection('css-styles'); ?>
    <?php echo $__env->yieldContent('moderator-css-styles'); ?>
<?php $__env->stopSection(); ?>

<!-- yield from app-base.blade.php -->
<?php $__env->startSection('js-scripts'); ?>
    <?php echo $__env->yieldContent('moderator-js-scripts'); ?>
<?php $__env->stopSection(); ?>

<!-- yield from app-base.blade.php -->
<?php $__env->startSection('navbar'); ?>
    <li><a href="<?php echo e(route('home-page')); ?>">Home</a></li>
    <li><a href="<?php echo e(route('read-posts')); ?>">Read Posts</a></li>
    <li><a href="<?php echo e(route('create-post')); ?>">Create Post</a></li>
    <?php echo $__env->make('components.navbar-user-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<!-- yield from app-master.blade.php -->
<?php $__env->startSection('sidebar-right'); ?>
    <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('read-my-posts')); ?>">Read My Posts</a></li>
    <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('moderate-posts')); ?>">Moderate Posts</a></li>
    <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('moderate-contributors')); ?>">Moderate Contributors</a></li>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/moderator/moderator-master.blade.php ENDPATH**/ ?>