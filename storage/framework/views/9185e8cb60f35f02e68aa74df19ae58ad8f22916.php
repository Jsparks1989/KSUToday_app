<!-- ====================================================================================================== 
 * Moderator read all posts view   
 
 * URL - APP_URL/read-posts

 * CHILD VIEW of - moderator.moderator-master      
 
 * What page is doing:
    - shows all posts with post_state = 'Published'

 * Controller 
    - PageController@readPosts -> ModeratorController@readPosts()
        > route - /read-posts
    - PageController@showPost -> ModeratorController@showPost() when user clicks on post title or 'read more'
        > route - /post/{post}
    - AjaxController@liveSearchReadPosts() populates page with posts & when user inputs search
        > route - /live-search-read-posts

 * JS file 
    - app/public/js/read-all-posts.js
    - app/public/js/root.js

 * CSS file
    - 
 ====================================================================================================== -->




<!-- yield from moderator.moderator-master -->
<?php $__env->startSection('moderator-css-styles'); ?>
    
<?php $__env->stopSection(); ?>

<!-- yield from moderator.moderator-master -->
<?php $__env->startSection('moderator-js-scripts'); ?>

<?php $__env->stopSection(); ?>


<!-- yield from component.app-base -->
<?php $__env->startSection('main'); ?>


    <script src="<?php echo e(asset('js/read-all-posts.js')); ?>"></script>

    <h1>Read Posts</h1>

    <div class="container-box">
        <label for="title">Title:</label>
        <input type="text" name="title" class="search_posts" id="title_search" placeholder="Search Posts by Title" />

        <label for="accounts_select">Posted By:</label>
        <input type="text" name="netID" class="search_posts" id="posted_by_search" placeholder="Search Posts by netID" />

        <!-- Categories -->
        <!-- <div class="form-input"> -->
        <label for="categories">Category:</label>
        <select name="categories_select" id="categories">
                <option name="category_item" id="category" value="0" selected>- All Categories -</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option name="category_item" id="category" value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <!-- </div> -->
        


        <div id="dynamic_content">
            <ul class="read-post-list">
            </ul>
            <br />
            <div id="pagination"></div>
        </div>


        
    </div>




    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('moderator.moderator-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/moderator/moderator-read-all-posts.blade.php ENDPATH**/ ?>