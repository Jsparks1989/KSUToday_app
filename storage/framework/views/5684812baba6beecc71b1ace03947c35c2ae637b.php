<!-- 
    This is the view that the user will be routed to when they log in and 
    the user's role is 'inactive' in the database.

    When user logs into SAML, in the middleware, check is the user is inactive.
    IF inactive, re-route user to this view.

    If the user is 'inactive', the user is logged out of the app. logged out 
    of SAML, and routed to this view.
 -->

<?php $__env->startSection('main'); ?>


    <div class="inner_rim">

        <div role="main" class="site_wrapper">
                
            <h1>Logged Out</h1>
            <p>You currently do not have access to KSU Today</p>
            


            <?php if(session('user-inactive')): ?>
                <h4><?php echo e(session('user-inactive')); ?></h4>
            <?php endif; ?>



        </div>

    </div>

    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/components/inactive-user.blade.php ENDPATH**/ ?>