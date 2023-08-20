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




{{--

    <!-- click to add a new email -->
    <button type="submit" class="btn search-btn" id="open_addDigestEmailModal">Add a New Email</button>

    

    


     <!-- Add New Category Modal -->
    <div id="addDigestEmailModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Add New Email:</h3>
            <!-- <label for="roles">New Category:</label> -->
            <input type="email" name="New Digest Email" id="new_digest_email_input" class="new_digest_email" placeholder="Enter new KSU email"/>

            <p id="not_new_email_error" class="addDigestEmailModal_errors" style="color:red; display:none;">This email address already exists. Please enter a new KSU email address.</p> 
            <p id="not_ksu_email_error" class="addDigestEmailModal_errors" style="color:red; display:none;">This is not a valid KSU email address. Please enter a new KSU email address.</p>  
            <button type="submit" class="btn search-btn" id="submit_new_digest_email">Submit</button>
        </div>

    </div> 
--}}

