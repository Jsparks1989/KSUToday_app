<!-- ====================================================================================================== 
 * 'Toast Settings' section of Toast Settings tab under settings  
 
 * URL - APP_URL/settings

 * CHILD VIEW of - N/A 
    - included on admin-settings.blade.php
 
 
 * What page is doing:
    - changing the message for each toast alert
    - changing the position for each toast alert
    - adding new message to display

 * Controller 
    - AjaxController@getAllToastData() get all toasts, messages and positions from toasts table, messages table, and positions table
        > route - /get-all-toast-data
    
    - AjaxController@updateToast() update edited toast in toasts table
        > route - /update-toast

    - AjaxController@addNewToastMessage() add new message to messages table
        > route - /add-new-toast-message


 * JS file 
    - app/public/js/admin/admin-settings-toast.js

 * CSS file
    - 
====================================================================================================== -->



    <h1>Toast Settings</h1>

    <!-- Create Post Toast -->
    <div id="create_post_settings">    
        <h2>'Create Post' Toast</h2>

        <label for="">Set Toast Position:</label>
        <select name="create post" class="toast_settings" id="create_post_toast_position_select">
        </select>

        <label for="">Set Toast Message:</label>
        <select name="create post" class="toast_settings" id="create_post_toast_message_select">
        </select>
    </div>

    <hr>

    <!-- Update Post Toast -->
    <div id="update_post_settings">
        <h2>'Update Post' Toast</h2>

        <label for="">Set Toast Position:</label>
        <select name="update post" class="toast_settings" id="update_post_toast_position_select">
        </select>

        <label for="">Set Toast Message:</label>
        <select name="update post" class="toast_settings" id="update_post_toast_message_select">
        </select>
    </div>

    <hr>

    <!-- Contributor Toast -->
    <div id="contributor_settings">
        <h2>'Contributor' Toast</h2>

        <label for="contributor">Set Toast Position:</label>
        <select name="contributor" class="toast_settings" id="contributor_toast_position_select">
        </select>

        <label for="contributor">Set Toast Message:</label>
        <select name="contributor" class="toast_settings" id="contributor_toast_message_select">
        </select>
    </div>

    <hr>

    <!-- Update User Toast -->
    <div id="update_user_settings">
        <h2>'Update User' Toast</h2>


        <label for="">Set Toast Position:</label>
        <select name="update user" class="toast_settings" id="update_user_toast_position_select">
        </select>

        <label for="">Set Toast Message:</label>
        <select name="update user" class="toast_settings" id="update_user_toast_message_select">
        </select>
    </div>

    <hr>

    <!-- Create User Toast -->
    <div id="create_user_settings">
        <h2>'Create User' Toast</h2>


        <label for="">Set Toast Position:</label>
        <select name="create user" class="toast_settings" id="create_user_toast_position_select">
        </select>

        <label for="">Set Toast Message:</label>
        <select name="create user" class="toast_settings" id="create_user_toast_message_select">
        </select>
    </div>


    <button class="btn search-btn" id="open_message_modal">Add Message</button>



    <!-- add new message modal -->
    <div id="add_message_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Add New Toast Message:</h3>
            <input type="text" name="" id="new_toast_message" class="" placeholder="Enter New Message"/>

            <p id="not_new_toast_message_error" style="color:red; display:none;">Please enter a new toast message.</p>    
            <button type="submit" class="btn search-btn" id="submit_new_msg">Submit</button>
        </div>

    </div>

















<?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/toast-settings-tab/toast-settings.blade.php ENDPATH**/ ?>