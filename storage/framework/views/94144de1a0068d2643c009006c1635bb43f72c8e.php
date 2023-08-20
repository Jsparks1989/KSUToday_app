<!-- ====================================================================================================== 
 * Moderator read my posts view   
 
 * URL - APP_URL/read-my-posts

 * CHILD VIEW of - moderator.moderator-master      
 
 * What page is doing:
    - shows all posts that were created by user, regardless of post_state

 * Controller 
    - PageController@readMyPosts -> ModeratorController@readMyPosts()
        > route - /read-my-posts
    - PageController@showPost -> ModeratorController@showPost() when user clicks on post title or 'read more'
        > route - /post/{post}
    - AjaxController@liveSearchMyPosts() when user inputs search
        > route - /live-search-my-posts

 * JS file 
    - app/public/js/read-my-posts.js
    - app/public/js/root.js

 * CSS file
    - 
 ====================================================================================================== -->





<!-- yield from moderator.moderator-master -->
<?php $__env->startSection('moderator-js-scripts'); ?>
    <script src="<?php echo e(asset('js/read-my-posts.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<!-- yield from moderator.moderator-master -->
<?php $__env->startSection('moderator-css-styles'); ?>
    
<?php $__env->stopSection(); ?>

<!-- yield from component.app-base -->
<?php $__env->startSection('main'); ?>


    <h1>Read My Posts</h1>

    <div class="container-box">
        <label for="title_summary">Search by Title & Summary:</label>
        <input type="text" name="title_summary" class="search_my_posts" id="my_posts_search" placeholder="Search" />
        <!-- Hidden input field that passes in the Auth::user's id -->
        <input type="hidden" name="user_id" class="search_my_posts" id="user_id" value="<?php echo e(Auth::user()->id); ?>">



        <div id="dynamic_content">
            <ul class="read-post-list">
            </ul>
            <br />
            <div id="pagination"></div>
        </div>

    </div>
    

    




    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('moderator.moderator-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/moderator/moderator-read-my-posts.blade.php ENDPATH**/ ?>