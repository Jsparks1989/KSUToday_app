    
    
    
    
    
    <h2>Alias Names</h2>
    <div id="accounts_list"></div>


    <button type="submit" class="btn search-btn" id="add_account">Add an Alias Name</button>


    <!-- PUT MODAL HERE -->
    <!-- The Modal -->
    <div id="accountModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Edit Alias Name:</h3>
            <label for="roles">Current Alias Name:</label>
            <input type="text" name="current_account" class="current_account" readonly='readonly'/>

            <label for="roles">Updated Alias Name:</label>
            <input type="text" name="updated_account" class="updated_account"  placeholder="Enter New Alias Name" />

            <p id="not_a_account_error" style="color:red; display:none;">Please enter a new alias name.</p>    
            <button type="submit" class="btn search-btn" id="submit_acct_change">Submit</button>
        </div>

    </div>




    <!-- 
        NEXT STEP IS TO FIX THE LOGIC FOR VALIDATING INPUT & ADDING ACCOUNT INPUT TO ACCOUNTS TABLE
     -->
     <div id="addAccountModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Add Alias Name:</h3>
            <label for="roles">New Alias Name:</label>
            <input type="text" name="new_account" class="new_account" placeholder="Enter New Alias Name"/>

            <p id="not_new_account_error" style="color:red; display:none;">Please enter a new alias name.</p>    
            <button type="submit" class="btn search-btn" id="submit_new_acct">Submit</button>
        </div>

    </div><?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-settings-alias-names.blade.php ENDPATH**/ ?>