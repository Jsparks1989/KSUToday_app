<!-- ====================================================================================================== 
 * 'Pair User Alias Names' section of Alias Names tab under settings  
 
 * URL - APP_URL/settings

 * CHILD VIEW of - N/A 
    - included on admin-settings.blade.php
 
 
 * What page is doing:
    - pairing account/alias names with users
    - removing account/alias names user association 

 * Controller 
    - AjaxController@searchUsersPairAccount() get users and droppable box as current user enters in input search
        > route - /search-users-pair-account

    - AjaxController@getAccounts() get all account/alias names to pair with users
        > route - /get-accounts

    - AjaxController@detachUserAccountPair() delete account-user association from account_user table
        > route - /detach-user-account-pair

    - AjaxController@attachUserAccountPair() add account-user association to account_user table
        > route - /attach-user-account-pair


 * JS file 
    - app/public/js/admin/admin-settings-pair-user-alias.js

 * CSS file
    - 
====================================================================================================== -->

    <!-- styling for droppable box under users -->
    <!-- <style>
        #div1, #div2 {
            float: left;
            width: 100px;
            height: 35px;
            margin: 10px;
            padding: 10px;
            border: 1px solid black;
        }
    </style> -->



    <h1>Pair User with Alias Names</h1>

    <label for="user_search">Search users by netID:</label>
    <input type="text" name="user_search" class="search_my_posts" id="user_search" placeholder="Search" />


    <div id="users_accounts_wrapper">

        <!-- where users and their droppable boxes load -->
        <div id="users_here"></div>

        <!-- where draggable account/alias names load -->
        <div id="accounts_here"></div>
    </div>
    



<?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/alias-names-tab/pair-user-alias.blade.php ENDPATH**/ ?>