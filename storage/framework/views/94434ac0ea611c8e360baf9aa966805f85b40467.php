

<!-- ==========================================================================
    JavaScript for Editing Alias Names/Accounts
    and Adding New Alias Names/Accounts 

    Used for: admin-settings-alias-names.blade.php
========================================================================== -->


<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        /**
        * =============================================================================== 
        * Grabbing All Account (Alias) Names
        * ===============================================================================
        */
        var alias_names;
        $.ajax({
            'async': false,
            'type': "get",
            'global': false,
            'dataType': 'json',
            'url': "/get-accounts",
            // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
            'success': function (data) {
                alias_names = data.alias_names;
            }
        })
        // console.log(alias_names);

        /**
        * =============================================================================== 
        * Get/Populate list of alias accounts
        * ===============================================================================
        */

        function get_accounts(){
            $.ajax({
                url: '/get-accounts-edit',
                type: 'get',
                // data: {query:query},
                dataType: 'json',
                success: function(data) {
                    // $('tbody').html(data.table_data);
                    $('#accounts_list').html(data.output);
                    // $('#total_records').text(data.total_data);
                    // console.log('data', data);

                },
            });
        }
        get_accounts();


        /**
        * =============================================================================== 
        * Display Accounts/Alias Modal Window
        * ===============================================================================
        */

        function openModal(id) {
            $.ajax({
                url: '/get-account/'+ id,
                type: 'get',
                // data: {query:query},
                dataType: 'json',
                success: function(data) {
                    // console.log('category data', data.output);
                    // $('.current_account').val(data.output['name']);
                    $('.updated_account').attr('id', data.output['id']);
                    $('.updated_account').attr('placeholder', data.output['name']);
                    var modal = $('#accountModal');
                    modal.css({ display: "block" });

                    document.getElementsByClassName('updated_account')[0].focus();
                    document.getElementById('not_a_account_error').style.display='none';
                }
            }); 
        }

        $('#accounts_list').on('click', '.accounts', function(){
            openModal($(this).attr('id'));
        });




        /**
        * =============================================================================== 
        * Close Accounts/Alias Modal Window
        * ===============================================================================
        */

        function closeModal() {
            $('input.updated_account').val('');
            let modal = $('#accountModal');
            modal.css({ display: "none" });
        }

        $(document).on('click', '.close', function(){
            closeModal();

        });

        
        /**
        * =============================================================================== 
        * Submit/Validate Accounts/Alias Edit Change
        * ===============================================================================
        */
        //-- Validate that the updated account value is not null && updated account value is not already an account name
        function validateAccount(updatedAcct) {
            let not_account_error = $('#not_a_account_error');
            let account_input = $('.updated_account').first();
            if(updatedAcct) {
                if(!alias_names.includes(updatedAcct)) {
                    not_account_error.css({ display: "hidden" });
                    return true;
                } else {
                    not_account_error.css({ display: "block" });
                    account_input.focus();
                    return false;
                }
            } else {
                not_account_error.css({ display: "block" });
                account_input.focus();
                return false;
            }
        }

        //-- Update the account name to the new account name
        function editAccount(id, value) {
            $.ajax({
                url: '/edit-account/'+ id + '/' + value,
                type: 'get',
                // data: {query:query},
                dataType: 'json',
                success: function(data) {
                    console.log('data: ', data);
                    closeModal();
                    
                    window.location.href = "<?php echo e(route('settings')); ?>";
                    //-- Need to be on 'Alias Names' tab when refresh --//
                    //-- input#tab2 needs to be checked --//

                    // $('div.tabset').on('load', function() {
                    //     $('#tab2').prop('checked', true);
                    // });
                    
                }
            }); 
        }

        $(document).on('click', '#submit_acct_change', function(){
            let acct_id = $('.updated_account').attr('id');
            let updated_acct = $('.updated_account').val();
            let current_acct = $('.current_account').val();
            
            //-- Validate the input
            
            if(validateAccount(updated_acct)) {
                editAccount(acct_id, updated_acct);
            } 
        });
        

       /**
        * =============================================================================== 
        * Open/Close Add CategoryAccount/Alias Modal Window
        * ===============================================================================
        */

        function openAddAcctModal() {
            $('#addAccountModal').css({ display: "block" }); 
            document.getElementById('not_new_account_error').style.display='none';
        }

        $(document).on('click', '#add_account', function(){
            openAddAcctModal();
            document.getElementsByClassName('new_account')[0].focus();
        });


        function closeAddCatModal() {
            $('.new_account').first().val('');
            $('#addAccountModal').css({ display: "none" });
            // $('#not_new_account_error').css({display: "hidden"});
        }

        $(document).on('click', '.close', function(){
            closeAddCatModal();

        });

        /**
        * =============================================================================== 
        * Submit/Validate New Account/Alias 
        * ===============================================================================
        */

        function validateNewAccount(newAcct) {
            if(newAcct) {
                if(!alias_names.includes(newAcct)) {
                    document.getElementById('not_new_account_error').style.display='hidden';
                    return true;
                } else {
                    document.getElementById('not_new_account_error').style.display='block';
                    document.getElementsByClassName('new_category')[0].focus();
                    return false;
                }
            } else {
                document.getElementById('not_new_account_error').style.display='block';
                document.getElementsByClassName('new_category')[0].focus();
                return false;
            }
        }

        function addAccount(query) {
            console.log('addAccount(): ', query);
            $.ajax({
                url: '/add-account',
                type: 'get',
                data: {query:query},
                dataType: 'json',
                success: function(data) {
                    console.log('ajax returned data:', data);
                    window.location.href = "<?php echo e(route('settings')); ?>";
                    //-- Need to be on 'Alias Names' tab when refresh --//
                    //-- input#tab2 needs to be checked --//
                    $('#tab1').prop('checked', false);
                    $('#tab2').prop('checked', true);
                }
            });
        }


        $(document).on('click', '#submit_new_acct', function(){
            let new_acct = $('.new_account').first().val();
            console.log(new_acct);

            if(validateNewAccount(new_acct)) {
                addAccount(new_acct);
            }
        });

    });
</script><?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/settings-js/admin-settings-js-alias-names.blade.php ENDPATH**/ ?>