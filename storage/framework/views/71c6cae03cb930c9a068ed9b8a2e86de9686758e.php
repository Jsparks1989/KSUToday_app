<!-- ====================================================================================================== 
 * General System Config tab under settings 
 
 * LOCATION - app/resources/views/admin/settings/general-systems-config
 
 * URL - APP_URL/settings

 * CHILD VIEW of - N/A 
    - included on admin-settings.blade.php
 
 
 * What page is doing:
    - Choosing the email that the digest is sent to 
    - Adding email addresses to digest_emails table

 * Controller 
    - AjaxController@getDigestEmails() get all emails from digest_emails table
        > route - /get-digest-emails
        
    - AjaxController@addDigestEmail() add new email to digest_emails table
        > route - /add-digest-email

    - AjaxController@updateCronJobDigest() update the cron_job_digests table
        > route - /update-cron-job-digest

    - () 
        > route - 

    

 * JS file 
    - app/public/js/settings/admin-settings.js
    - app/public/js/settings/general-system-config/digest-email.js

 * CSS file
    - 
====================================================================================================== -->


    <h2>Digest Email</h2>


    <div id="digest_emails">    
        <!-- <h2>Select Digest Email</h2> -->

        <label for="Digest Email">Select Digest Email:</label>
        <select name="Digest Email" id="digest_email_select">
        </select>

    </div>






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


<?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/general-system-config-tab/digest-email.blade.php ENDPATH**/ ?>