<!-- ====================================================================================================== 
 * 'Edit Alias Names' section of Alias Names tab under settings  
 
 * URL - APP_URL/settings

 * CHILD VIEW of - N/A 
    - included on admin-settings.blade.php
 
 
 * What page is doing:
    - can add a new alias name 
    - can edit a current alias name 

 * Controller 
    - AjaxController@getAccountsEdit() get all account/alias names to be able to edit
        > route - /get-accounts-edit

    - AjaxController@getAccount() get account user wants to edit and load it into modal window
        > route - /get-account/{id}

    - AjaxController@editAccount() update the account name in accounts table after user edits
        > route - /edit-account/{id}/{value}

    - AjaxController@addAccount() add new account to accounts table 
        > route - /add-account


 * JS file 
    - app/public/js/admin/admin-settings-alias-names.js

 * CSS file
    - 
====================================================================================================== -->
 
    
    <h2>Edit Alias Names</h2>

    <!-- where account/alias names load to be able to edit -->
    <div id="accounts_list"></div>


    <!-- click to add a new account/alias -->
    <button type="submit" class="btn search-btn" id="add_account">Add an Alias Name</button>


  
    <!-- modal for editing account/alias name -->
    <div id="accountModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Edit Alias Name:</h3>
            <input type="text" name="updated_account" class="updated_account"/>

            <p id="not_a_account_error" style="color:red; display:none;">Please enter a new alias name.</p>    
            <button type="submit" class="btn search-btn" id="submit_acct_change">Submit</button>
        </div>

    </div>


    <!-- modal for adding account/alias name -->
    <div id="addAccountModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Add a New Alias Name:</h3>
            <input type="text" name="new_account" class="new_account" placeholder="Enter New Alias Name"/>

            <p id="not_new_account_error" style="color:red; display:none;">Please enter a new alias name.</p>    
            <button type="submit" class="btn search-btn" id="submit_new_acct">Submit</button>
        </div>

    </div><?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/alias-names-tab/alias-names.blade.php ENDPATH**/ ?>