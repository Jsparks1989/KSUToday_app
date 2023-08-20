<!-- ====================================================================================================== 
 * Contributor posts status view   
 
 * URL - APP_URL/posts-status

 * CHILD VIEW of - contributor.contributor-master      
 
 * Ajax call builds out table of all the posts made by the user
    - posts are appended to tbody#posts_list
    - pagination is appended to div#pagination

 * Controller
    - PageController@postsStatus() -> ContributorController@postsStatus()
        > route - /posts-status
    - AjaxContributor@liveSearchContribPostsStatus() when inputing search
        > route - /live-search-contrib-posts-status

 * JS file 
    - app/public/js/contributor/contrib-post-status.js
    - app/public/js/root.js

 * CSS file
    - 
 ====================================================================================================== -->






<!-- yield from component.app-base -->
<?php $__env->startSection('main'); ?>

    <script src="<?php echo e(asset('js/contributor/contrib-post-status.js')); ?>"></script>

    <h1>Posts Status</h1>

    <div class="container-box">
        <label for="title_summary">Search by Title:</label>
        <input type="text" name="title_summary" class="search_my_posts" id="contrib_posts_status_search" placeholder="Search" />
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
                </tr>
            </tfoot>
        </table>
        <br />

        <div id="pagination"></div>
        </div>
        
    </div>

    
    
    <!-- Old form -->
    

    <!-- Old table -->
    

    
<?php $__env->stopSection(); ?>




<?php echo $__env->make('contributor.contributor-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/contributor/contributor-posts-status.blade.php ENDPATH**/ ?>