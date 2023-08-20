



<?php $__env->startSection('sidebar'); ?>
<div class="sidebar right">
    <div class="secondary_nav">
        <h1>User Menu</h1>

        <ul>
            <li><a href=""><?php echo e(Auth::user()->name); ?></a></li>

            <?php echo $__env->yieldContent('sidebar-right'); ?>

            <li>
                <a href="<?php echo e(route('logout')); ?>"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <?php echo e(__('Logout')); ?>

                </a>

                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                    <?php echo csrf_field(); ?>
                </form>
            </li>
            
        </ul>
    </div>                    
</div><!-- /sidebar -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/components/app-master.blade.php ENDPATH**/ ?>