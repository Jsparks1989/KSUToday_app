



    <!-- <link href="<?php echo e(asset('css/ksu_css/sidebar.css')); ?>" rel="stylesheet"> -->


<?php $__env->startSection('sidebar'); ?>

    <script>
        //-- JQUERY CODE THAT HIGHLIGHTS THE CURRENT PAGE LINK IN THE RIGHT SIDEBAR --//
        $(document).ready(function() {
            $(".sidebar-background [href]").each(function() {
                if (this.href == window.location.href) {
                    $(this).parent().addClass("active-link");
                }
            });
        });
    </script>


    <!-- STYLING THAT CUT THE CORNER OF THE SIDE-BAR USER MENU  -->
    <!-- 
        <style>
            #sidebar {
                -webkit-clip-path: polygon(0 0, 0 100%, 100% 100%, 100% 25%, 75% 0);
                clip-path: polygon(0 0, 0 100%, 100% 100%, 100% 25%, 75% 0);
                /* background: green; */
            }
        </style>
    -->

    <!-- <div class="sidebar right" style=""> -->
    <div class="sidebar right" id="sidebar">
        <div class="secondary_nav">
            <h2 class="sidebar-header">User Menu</h2>

            <ul>
                <!-- <li><a href=""><?php echo e(Auth::user()->name); ?></a></li> -->
                <!-- <li><p style="color: #007A95; font: 16.32px Arial, Helvetica, sans-serif; padding: 10.88px 6.3875px">Logged in as <?php echo e(Auth::user()->name); ?></p></li> -->
                <li class="sidebar-user sidebar-font">Logged in as <span class="bold"><?php echo e(Auth::user()->name); ?></span></li>
                    <!-- class="sidebar-user sidebar-font" -->
                <?php echo $__env->yieldContent('sidebar-right'); ?>

                
        <!-- 
            Logout needs to route to a logout view letting user know 'Logged Out, You have successfully logged out.'
            components/logout.blade.php



            Include the javascript code below in <script> tag

            // logs user out
                    function logout(){
            //                console.log("logout");
            //                window.location.reload();
                        // destroy cookie to prevent bad logout
                        //document.cookie = "mellon-cookie=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
                        window.location = "https://intweb.kennesaw.edu/mellon/logout?ReturnTo=https://intweb.kennesaw.edu/loggedout.php";
                    }
                    // logout button (in header)
                    $logout.click(function(e){
                        e.preventDefault();
                        logout();
                    });


        -->



                <li class="sidebar-background">
                    <a class="sidebar-link" href="<?php echo e(route('logout-user')); ?>">
                        Logout
                    </a>
                </li>
            </ul>
        </div>                    
    </div><!-- /sidebar -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/components/app-master.blade.php ENDPATH**/ ?>