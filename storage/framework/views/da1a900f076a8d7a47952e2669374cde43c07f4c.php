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
    - () 
        > route - 
        
    - () 
        > route - 

    - () 
        > route - 

    - () 
        > route - 

    

 * JS file 
    - app/public/js/admin-settings-.js

 * CSS file
    - 
====================================================================================================== -->


    <h2>Digest Email List</h2>
    
    <div id="general_settings_email">

        <div id="digest_email_list"></div>
    </div>

    <!-- click to add a new email -->
    <button type="submit" class="btn search-btn" id="open_addDigestEmailModal">Add a Category</button>

    

    


     <!-- Add New Category Modal -->
    <div id="addDigestEmailModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Add New Email:</h3>
            <!-- <label for="roles">New Category:</label> -->
            <input type="email" name="New Digest Email" id="new_digest_email_input" class="new_digest_email" placeholder="Enter New Email"/>

            <p id="digest_email_error" style="color:red; display:none;">Please enter a new category name.</p>    
            <button type="submit" class="btn search-btn" id="submit_new_digest_email">Submit</button>
        </div>

    </div>
    









<?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/general-system-config/digest-email.blade.php ENDPATH**/ ?>