<!-- ====================================================================================================== 
 * General System Config tab under settings 
 
 * LOCATION - app/resources/views/admin/settings/general-systems-config
 
 * URL - APP_URL/settings

 * CHILD VIEW of - N/A 
    - included on admin-settings.blade.php
 
 
 * What page is doing:
    - 
    - 

 * Controller 
    - AjaxController@getNumPostsDisplayed() get data from display_posts table
        > route - /get-posts-per-page
        
    - AjaxController@updateNumDisplayed() update number_displayed column data in display_posts table
        > route - /update-num-displayed

    - () 
        > route - 

    - () 
        > route - 

    

 * JS file 
    - app/public/js/admin-settings-.js
    - app/public/js/settings/general-system-config/num-posts-displayed.js

 * CSS file
    - 
====================================================================================================== -->



    <h2>Number of Posts Displayed</h2>

    
    <div id="posts_displayed">    
        <!-- <h2>Select Digest Email</h2> -->

        <label for="Digest Email">Number of Posts Displayed per Page:</label>
        <select name="posts per page" id="posts_per_page_select">
        </select>

    </div>






<?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/general-system-config-tab/num-posts-displayed.blade.php ENDPATH**/ ?>