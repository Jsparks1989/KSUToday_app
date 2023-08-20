

    <!-- 
        Styling from:
        css/ksu_css/navbar_user_menu.css
        css/ksu_css/sidebar.css 
    -->
    <li id="user_menu_gold_bar" class="dropdown">
    <a href="#">User Menu</a>
        <div class="sidebar" id="">

            <div class="dropdown-content secondary_nav">
            <!-- <div class="secondary_nav"> -->

                <ul>
                    <?php if(Auth::user()->role_id == 2): ?>
                        <li class="sidebar-background"><a class="sidebar-background sidebar-link" href="<?php echo e(route('read-my-posts')); ?>">Read My Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-background sidebar-link" href="<?php echo e(route('post-status')); ?>">View Status of Posts</a></li>
                    <?php elseif(Auth::user()->role_id == 3): ?>
                        <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('read-my-posts')); ?>">Read My Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('moderate-posts')); ?>">Moderate Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('moderate-contributors')); ?>">Moderate Contributors</a></li>
                    <?php elseif(Auth::user()->role_id == 4): ?>
                        <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('read-my-posts')); ?>">Read My Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('moderate-posts')); ?>">Moderate Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('moderate-users')); ?>">Moderate Users</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('settings')); ?>">Settings</a></li>
                    <?php endif; ?>
                        <li class="sidebar-background"><a class="sidebar-link" href="<?php echo e(route('logout-user')); ?>">Logout</a></li>
                </ul>
            </div>
        </div>  
    </li><?php /**PATH /var/www/ksutodaytest/resources/views/components/navbar-user-menu.blade.php ENDPATH**/ ?>