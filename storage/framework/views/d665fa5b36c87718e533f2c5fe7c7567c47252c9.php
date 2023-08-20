<?php $__env->startSection('main'); ?>

<script>

    // logs user out
    function logout(){
        console.log("logout");
        window.location.reload();
        // destroy cookie to prevent bad logout
        document.cookie = "mellon-cookie=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        // window.location = "https://intweb.kennesaw.edu/mellon/logout?ReturnTo=https://intweb.kennesaw.edu/loggedout.php";

        // window.location = "http://ksutodaytest.kennesaw.edu/mellon/logout?ReturnTo=http://ksutodaytest.kennesaw.edu/public/index.php";
        window.location = "http://ksutodaytest.kennesaw.edu/mellon/logout?ReturnTo=http://ksutodaytest.kennesaw.edu/public/index.php";
    }


    // logout button (in header)
    // logout.click(function(e){
    //     e.preventDefault();
    //     logout();
    // });

</script>


    <div class="inner_rim">

        <div role="main" class="site_wrapper">

            <?php if(session('user-inactive')): ?>
                <h4><?php echo e(session('user-inactive')); ?></h4>
                <a onclick="logout()" href="#" class="btn btn-login">LOG IN</a>
            <?php else: ?>
                <h1>Logged Out</h1>
                <p>You have successfully logged out.</p>

                
                <a onclick="logout()" href="#" class="btn btn-login">LOG IN</a>
            <?php endif; ?>

            

        </div>

    </div>

    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/components/logout.blade.php ENDPATH**/ ?>