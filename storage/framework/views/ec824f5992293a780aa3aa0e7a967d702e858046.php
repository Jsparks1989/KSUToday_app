


<?php $__env->startSection('main'); ?>

      







<div class="inner_rim">

    <div role="main" class="site_wrapper">
            
        <p>KSU Today is Kennesaw State University's system for posting and viewing campus announcements for faculty&nbsp;and staff.</p>
        <p>To access KSU Today, please log-in with your full KSU email address and&nbsp;<a href="https://netid.kennesaw.edu" title="KSU NetID">NetID&nbsp;password</a>.&nbsp; KSU Today uses Duo two-factor authentication; <a href="https://uits.kennesaw.edu/duo" title="KSU two-factor authentication">learn more here</a>.</p>

        <div class="center">
            <a href="<?php echo e(route('login')); ?>" class="btn btn-login">LOG IN</a>
        </div>

        <div>
            <?php if(session('user-inactive')): ?>
                <div><h4 class="error"><?php echo e(session('user-inactive')); ?></h4></div>
            <?php endif; ?>
        </div>

    </div>

</div>



    


    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/root-login.blade.php ENDPATH**/ ?>