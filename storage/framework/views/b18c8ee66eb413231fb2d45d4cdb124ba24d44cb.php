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
    - AjaxController@getDigestEmails() get all emails from digest_emails table
        > route - /get-digest-emails
        
    - AjaxController@addDigestEmail() add new email to digest_emails table
        > route - /add-digest-email

    - () 
        > route - 

    - () 
        > route - 

    

 * JS file 
    - app/public/js/admin-settings-.js
    - app/public/js/settings/general-system-config/cron-scheduler.js

 * CSS file
    - 
====================================================================================================== -->

    <script src="<?php echo e(asset('js/cron/jqCron.js')); ?>"></script>
    <script src="<?php echo e(asset('js/cron/jqCron.en.js')); ?>"></script>
    <link type="text/css" href="<?php echo e(asset('css/cron/jqCron.css')); ?>" rel="stylesheet" />

    <h2>Cron Schedule</h2>

    
    






<?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/general-system-config-tab/cron-scheduler.blade.php ENDPATH**/ ?>