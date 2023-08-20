
<!-- ====================================================================================================== -->
<!-- PARENT VIEW for EVERYONE after user logs in and is authenticated                                            -->
<!-- Includes: #header, #main, #sidebar-right, #footer                                                      -->

<!-- The only 3 divs that should be altered are: #header, #main and #sidebar-right                          -->
<!-- #header @navbar  includes:                              -->
<!--    1) Read Posts btn -->


<!-- #main will display different content depending on user's status                                        -->
<!-- #sidebar-right will display different user menu buttons/functions depending on user's status           -->
<!-- ====================================================================================================== -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- JQuery 3.x CDN -->
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <title>KSUToday</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <style>
        #header{
            background-color: lightblue;
            width:100%;
            height:100px;
            text-align: center;
        }

        #main{
            float:left;
            width:70%;
            background-color: lightgray;
        }

        #sidebar-right{
            float:left;
            width:30%;
            background-color: silver;
        }

        #footer{
            clear:both;
            height: 150px;
            width: 100%;
            text-align: center;
            background-color: lightblue;
        }

        #sidebar-left, #main, #sidebar-right{
            min-height: 600px				
        }
	</style>
    <link href="<?php echo e(asset('css/app-master.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldContent('css-styles'); ?>
    
</head>
<body>
    <div id="header">
        <h3>Header</h3>
        <?php echo $__env->yieldContent('navbar'); ?>
    </div>

    <div id="main">
        <?php echo $__env->yieldContent('main'); ?>
    </div>

<!-- Right Side Bar: User Menu -->
    <div id="sidebar-right">
        <h3>User Menu</h3>
        <?php echo $__env->yieldContent('sidebar-right'); ?>
        <!-- Add the logout button -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <?php if(auth()->guard()->guest()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                </li>
            <?php else: ?>
                <li>
                    <a>
                        <?php echo e(Auth::user()->name); ?>

                    </a>

                    <div>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <?php echo e(__('Logout')); ?>

                        </a>

                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <div id="footer">
        <h3>Footer</h3>
    </div>
    <?php echo $__env->yieldContent('js-scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/components/app-master.blade.php ENDPATH**/ ?>