<!-- ====================================================================================================== 
 * Admin moderate posts view   
 
 * URL - APP_URL/moderate-posts

 * CHILD VIEW of - admin.admin-master      
 
 * What page is doing:
    - lists all posts regardless of post_state
    - user can change post_state for each post in drop-down
    - user can edit post by clicking 'edit post' link
    - input search will search posts by 'title' & 'posted by' ('title' and 'from_account' in posts table)

 * Controller 
    - PageController@moderatePosts() -> AdminController@moderatePosts()
        > route - /moderate-posts

    - AjaxController@editPostState() when user updates post state
        > route - /update-post-state/{id}/{state}

    - AjaxController@liveSearchAdminPostsStatus() display posts and when user searches posts
        > route - /live-search-admin-posts-status

    - PageController@editPost() -> ModeratorController@editPost() when user clicks 'edit post'
        > route - /edit-post/{post}

 * JS file 
    - app/public/js/root.js
    - app/public/js/admin/admin-moderate-posts.js
    - app/public/js/toast/global-toast-variables-functions.js
    - app/public/js/toast/toastr.js
    - app/public/js/toast/toast-messages.js

 * CSS file
    - 
 ====================================================================================================== -->






<!-- yield from admin-master.blade.php -->
<?php $__env->startSection('admin-js-scripts'); ?>
    <script src="<?php echo e(asset('js/admin/admin-moderate-posts.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<!-- yield from admin-master.blade.php -->
<?php $__env->startSection('admin-css-styles'); ?>

<?php $__env->stopSection(); ?>

<!-- yield from components.app-master -->
<?php $__env->startSection('main'); ?>


    <?php echo $__env->make('components.sessions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    

    <h1>Moderate Posts</h1>

    
    <div class="container-box">
        <label for="title_summary">Search by Title & Posted By:</label>
        <input type="text" name="title_summary" class="search_my_posts" id="posts_status_search" placeholder="Search" />
        <!-- Hidden input field that passes in the Auth::user's id -->
        <input type="hidden" name="user_id" class="search_my_posts" id="user_id" value="<?php echo e(Auth::user()->id); ?>">
    </div>






    <div id="dynamic_content">

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Posted By</th>
                    <th class="mp-update-at">Updated At</th>
                    <th class="mp-state">State</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody id="posts_list">


            </tbody>
            <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Posted By</th>
                    <th class="mp-update-at">Updated At</th>
                    <th class="mp-state">State</th>
                    <th>Edit</th>
                </tr>
            </tfoot>
        </table>
        <br />

        <div id="pagination"></div>

    </div>


    <!-- Old Form -->
    

    <!-- Old DataTale -->
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-moderate-posts.blade.php ENDPATH**/ ?>