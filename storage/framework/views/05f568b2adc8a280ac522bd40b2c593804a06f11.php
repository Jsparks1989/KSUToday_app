<!-- ====================================================================================================== 
 * Moderator moderate posts view   
 
 * URL - APP_URL/moderate-posts

 * CHILD VIEW of - moderator.moderator-master      
 
 * What page is doing:
    - lists all posts where post_state != 'Published'
    - user can change post_state for each post in drop-down
    - user can edit post by clicking 'edit post' link
    - input search will search posts by 'title' & 'posted by' ('title' and 'from_account' in posts table)

 * Controller 
    - PageController@moderatePosts() -> ModeratorController@moderatePosts()
        > route - /moderate-posts

    - AjaxController@editPostState() when user updates post state
        > route - /update-post-state/{id}/{state}

    - AjaxController@liveSearchModPostsStatus() when user searches posts
        > route - /live-search-mod-posts-status

    - PageController@editPost() -> ModeratorController@editPost() when user clicks 'edit post'
        > route - /edit-post/{post}

 * JS file 
    - app/public/js/root.js
    - app/public/js/moderator/mod-moderate-posts.js
    - app/public/js/toastr.js
    - app/public/js/toast-messages.js

 * CSS file
    - 
 ====================================================================================================== -->







<!-- yield from moderator-master.blade.php -->
<?php $__env->startSection('moderator-js-scripts'); ?>
    <script src="<?php echo e(asset('js/moderator/mod-moderate-posts.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<!-- yield from moderator-master.blade.php -->
<?php $__env->startSection('moderator-css-styles'); ?>

<?php $__env->stopSection(); ?>

<!-- yield from components.app-master -->
<?php $__env->startSection('main'); ?>

    <h1>Moderate Posts</h1>


    <?php echo $__env->make('components.sessions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="container-box">
        <label for="title_summary">Search by Title & Posted By:</label>
        <input type="text" name="title_summary" class="search_my_posts" id="posts_status_search" placeholder="Search" />
        <!-- Hidden input field that passes in the Auth::user's id -->
        <input type="hidden" name="user_id" class="search_my_posts" id="user_id" value="<?php echo e(Auth::user()->id); ?>">




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

                <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Posted By</th>
                        <th class="mp-update-at">Updated At</th>
                        <th class="mp-state">State</th>
                        <th>Edit</th>
                    </tr>
                </tfoot>

                <tbody id="posts_list">
                    
                </tbody>

            </table>

            <br>
            
            <div id="pagination"></div>
        </div>


    </div>
    
    <!-- Old table posts populate -->
    



    <!-- Old form to search for posts -->
    
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('moderator.moderator-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/moderator/moderator-moderate-posts.blade.php ENDPATH**/ ?>