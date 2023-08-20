



    <h1>Global Settings</h1>

    <h2>'Create Post' Toast Settings</h2>


    <label for="">Set 'Create Post' Toast Position:</label>
    <select name="" class="toast_settings" id="create_post_toast_position_select">
    </select>

    <label for="">Set 'Create Post' Toast Message:</label>
    <select name="" class="toast_settings" id="create_post_toast_message_select">
    </select>


    <hr>


    <h2>'Update Post' Toast Settings</h2>


    <label for="">Set 'Update Post' Toast Position:</label>
    <select name="" class="toast_settings" id="update_post_toast_position_select">
    </select>

    <label for="">Set 'Update Post' Toast Message:</label>
    <select name="" class="toast_settings" id="update_post_toast_message_select">
    </select>




    <hr>


    <h2>'Contributor' Toast Settings</h2>


    <label for="">Set 'Contributor' Toast Position:</label>
    <select name="" class="toast_settings" id="contributor_toast_position_select">
    </select>

    <label for="">Set 'Contributor' Toast Message:</label>
    <select name="" class="toast_settings" id="contributor_toast_message_select">
    </select>




    <hr>


    <h2>'Update User' Toast Settings</h2>


    <label for="">Set 'Update User' Toast Position:</label>
    <select name="" class="toast_settings" id="update_user_toast_position_select">
    </select>

    <label for="">Set 'Update User' Toast Message:</label>
    <select name="" class="toast_settings" id="update_user_toast_message_select">
    </select>





    <hr>


    <h2>'Create User' Toast Settings</h2>


    <label for="">Set 'Create User' Toast Position:</label>
    <select name="" class="toast_settings" id="create_user_toast_position_select">
    </select>

    <label for="">Set 'Create User' Toast Message:</label>
    <select name="" class="toast_settings" id="create_user_toast_message_select">
    </select>














    <!-- 
        When I do messages, I need to keep in mind that the message 
        will differ depending on the user role and the actions
        ex. changing user role, editing post, post status, ex.

        Instead of updating the message directly of config(toast), 
        have another config(toast_messages) and config(toast_titles).
        Allow admins to edit the titles and messages, then set titles 
        and messages to the proper toast in toast-messages.js file.
     -->



<?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/admin-settings-global.blade.php ENDPATH**/ ?>