/* ==========================================================================
    JavaScript for admin-settings-alias-names.blade.php
    
    * Editing Alias Names/Accounts
    * Adding New Alias Names/Accounts 

========================================================================== */



    $(document).ready(function(){

        // GLOBALS to use throughout page
        

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        /**
         * =============================================================================== 
         * Set/Define Variables and Functions
         * ===============================================================================
         */

            // div#accounts_list
            var accounts_list = $('#accounts_list');

            // input.updated_account
            let updated_account = $('.updated_account');

            // div#accountModal
            let modal = $('#accountModal');

            // p#not_a_account_error
            let not_a_account_error = $('#not_a_account_error');

            // p#not_new_account_error
            let not_new_account_error = $('#not_new_account_error');

            // div#addAccountModal
            let addAccountModal = $('#addAccountModal');
       
            // input#new_account
            let new_account = $('.new_account');

            // div#accounts_here
            let accounts_here = $('#accounts_here');

            // hold all accounts
            var alias_names;

            // set alias_names variable
            function set_alias_names(data) {
                alias_names = data;
            }

            // get all accounts
            function get_accounts(){
                $.ajax({
                    url: '/get-accounts-edit',
                    type: 'get',
                    // data: {query:query},
                    dataType: 'json',
                    success: function(data) {
                        $(accounts_list).html(data.output);
                        set_alias_names(data.alias_names);

                    },
                });
            }

            // open edit alias name modal
            function openModal(id) {
                $.ajax({
                    url: '/get-account/'+ id,
                    type: 'get',
                    // data: {query:query},
                    dataType: 'json',
                    success: function(data) {
                        $(updated_account).attr('id', data.output['id']);
                        $(updated_account).attr('placeholder', data.output['name']);
                        $(modal).css({ display: "block" });
                        $(updated_account)[0].focus();
                        $(not_a_account_error).css('display','none');
                    }
                }); 
            }

            // close edit alias name modal
            function closeModal() {
                $(updated_account).val('');
                $(modal).css({ display: "none" });
            }

            // Validate that the updated account value is not null && updated account value is not already an account name
            function validateAccount(updatedAcct) {
                let account_input = $(updated_account).first();
                if(updatedAcct) {
                    if(!alias_names.includes(updatedAcct)) {
                        not_a_account_error.css({ display: "hidden" });
                        return true;
                    } else {
                        not_a_account_error.css({ display: "block" });
                        account_input.focus();
                        return false;
                    }
                } else {
                    not_a_account_error.css({ display: "block" });
                    account_input.focus();
                    return false;
                }
            }

            //-- Update the account name to the new account name
            function editAccount(id, value) {
                return new Promise ((resolve, reject) => {
                    $.ajax({
                        url: '/edit-account/'+ id + '/' + value,
                        type: 'get',
                        // data: {query:query},
                        dataType: 'json',
                        // success: function(data) {
                        //     $('#account_'+id).text(data.value);
                        //     closeModal();
                            
                        //     // window.location.href = data.settings_route;
                        //     //-- Need to be on 'Alias Names' tab when refresh --//
                        //     //-- input#tab2 needs to be checked --//
    
                        //     // $('div.tabset').on('load', function() {
                        //     //     $('#tab2').prop('checked', true);
                        //     // });
                            
                        // }
                        success: resolve,
                        error: resolve,
                    }); 
                });
                
            }

            // open the 'Add an Alias Name' modal
            function openAddAcctModal() { 
                $(not_new_account_error).css('display','none');
                $(addAccountModal).css('display','block');
            }

            // close modal when btn is clicked
            function closeAddActModal() {
                $(new_account).first().val('');
                $(addAccountModal).css({ display: "none" });
            }

            // add new alias name to accounts table
            function addAccount(query) {
                return new Promise ((resolve, reject) => {
                    $.ajax({
                        url: '/add-account',
                        type: 'get',
                        data: {query:query},
                        dataType: 'json',
                        success: resolve,
                        error: reject,
                    });
                });
                
            }

            // validate new account/alias name before submitting to accounts table
            function validateNewAccount(newAcct) {
                if(newAcct) {
                    if(!alias_names.includes(newAcct)) {
                        $(not_new_account_error).css('display','hidden');
                        return true;
                    } else {
                        $(not_new_account_error).css('display','block');
                        $(new_account)[0].focus();
                        return false;
                    }
                } else {
                    $(not_new_account_error).css('display','block');
                    $(new_account)[0].focus();
                    return false;
                }
            }


            // get all account/alias names to pair with users
            function get_alias_accounts() {
                return new Promise ((resolve, reject) => {
                    $.ajax({
                        'type': "get",
                        'dataType': 'json',
                        'url': "/get-accounts",
                        // 'success': function (data) {
                        //     get_accounts();
                        //     closeAddActModal();
                        //     // append all account/alias names to div#accounts_here
                        //     $(accounts_here).empty();
                        //     // $(accounts_here).html(data.user_pair_alias);
                        //     $(accounts_here).append(data.user_pair_alias);
                        //     // console.log(data.user_pair_alias);

                        //     $('.account_draggable').draggable({
                        //         snap: '.users',
                        //         stack: 'account_draggable',
                        //         cursor: 'move',
                        //         helper: 'clone',
                        //     });
                        // }
                        success: function(data) {
                            resolve(data);
                        },
                        error: reject,
                    });
                });
            }



        /**
        * =============================================================================== 
        * Get/Populate list of alias accounts to edit
        * ===============================================================================
        */

            get_accounts();


        /**
        * =============================================================================== 
        * Open/Close the Edit Accounts/Alias Modal Window
        * ===============================================================================
        */

            // open edit alias name modal when alias name is clicked 
            $(accounts_list).on('click', '.accounts', function(){
                get_accounts();
                let id = $(this).attr('id');
                id = id.substr(8);
                openModal(id);
            });       

            // close edit alias name modal when X is clicked
            $(document).on('click', '.close', function(){
                closeModal();
            });

        
        /**
        * ==================================================================================================== 
        * Validate/Submit Accounts/Alias Edit Change & Re-populate the account/alias names to pair with users
        * ====================================================================================================
        */
        

            $(document).on('click', '#submit_acct_change', function(){
                let acct_id = $(updated_account).attr('id');
                let updated_acct = $(updated_account).val();
                
                // If the edited name is validated
                if(validateAccount(updated_acct)) {
                    editAccount(acct_id, updated_acct).then((resolve) => {
                        get_accounts();
                        closeModal();

                        // re-populate 'Pair User with Alias Names' to so alias name edit is reflected
                        get_alias_accounts().then((resolve) => {
                            $(accounts_here).empty();
                            $(accounts_here).append(resolve.user_pair_alias);

                            // make all accounts in #accounts_here droppable after changes
                            $('.account_draggable').draggable({
                                snap: '.users',
                                stack: 'account_draggable',
                                cursor: 'move',
                                helper: 'clone',
                            });
                        });
                    }).catch((reject) => {
                        // alert(reject);
                    });
                } 
            });


       /**
        * =============================================================================== 
        * Open/Close 'Add an Alias Name' modal
        * ===============================================================================
        */

            // open modal when btn is clicked
            $(document).on('click', '#add_account', function(){
                openAddAcctModal();
                $(new_account)[0].focus();
            });

            // close modal when X is clicked
            $(document).on('click', '.close', function(){
                closeAddActModal();
            });

        /**
        * ===========================================================================================
        * Submit/Validate New Account/Alias & Re-populate the account/alias names to pair with users
        * ===========================================================================================
        */

            // when user submits new account/alias name 
            $(document).on('click', '#submit_new_acct', function(){
                let new_acct = $(new_account).first().val();
                if(validateNewAccount(new_acct)) {

                    
                    addAccount(new_acct).then((resolve) => {
                        // re-populate 'Pair User with Alias Names'
                        get_alias_accounts().then((resolve) => {
                            get_accounts();
                            closeAddActModal();

                            // append all account/alias names to div#accounts_here
                            $(accounts_here).empty();
                            $(accounts_here).append(resolve.user_pair_alias);

                            // make all accounts in #accounts_here droppable after new account is added
                            $('.account_draggable').draggable({
                                snap: '.users',
                                stack: 'account_draggable',
                                cursor: 'move',
                                helper: 'clone',
                            });
                        });

                    }).catch((reject) => {
                        // alert(reject);
                    });;     
                }
            });


    });
