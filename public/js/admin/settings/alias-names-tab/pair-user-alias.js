/* ==========================================================================
    JavaScript for admin-settings-pair-user-alias.blade.php

    * Adding account/alias name to user
    * Removing account/alias name to user

========================================================================== */

$(document).ready(function(){

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

        // div#users_here
        let users_here = $('#users_here');

        // div.users_alias_box
        // box below each user when searching
        // where account/alias names are dragged to 
        let users_alias_box = $('.users_alias_box');

        // input#user_search
        let user_search = $('#user_search');

        // div#accounts_here
        let accounts_here = $('#accounts_here');

        // account/alias names that are draggable to user_alias_box
        let account_draggable = $('.account_draggable');

        // query for users_live_search()
        let query = {
            'search_users': '',
            'role' : '',
        };

        // get users with droppable box below user's netID
        // droppable can only accept .account_draggable
        function users_live_search(query = ''){
            $.ajax({
                url: '/search-users-pair-account',
                type: 'get',
                data: {query:query},
                dataType: 'json',
                success: function(data) {
                    $(users_here).html(data.user_pair_alias);
                    // wont work when using variables, use strings
                    $('.users_alias_box').droppable({
                        accept: '.account_draggable',
                        drop: handleDropEvent,
                    });
    
                    droppedAccounts();
                }
            });
        }

        // get all account/alias names to pair with users
        function get_all_accounts(){
            $.ajax({
                'async': false,
                'type': "get",
                'global': false,
                'dataType': 'json',
                'url': "/get-accounts",
                'success': function (data) {
                    // append all account/alias names to div#accounts_here
                    $(accounts_here).html(data.user_pair_alias);
                }
            });
        }

        // Handle the drop event when user drags the draggable account/alias name to the droppable users_alias_box
        // Make the dragged account/alias name stay in droppable div.users_alias_box. 
        // Check to make sure there are no double draggable account/alias names in users_alias_box
        // Add account-user association to account_user table
        function handleDropEvent(event, ui) {
            // users_droppable_box that the user dragged a account/alias name into
            let droppable = $(this);
            let draggable = ui.draggable;
            let children = [];

            // get the id (user_{user's id number}) of droppable box 
            let droppable_id = $(droppable).attr('id');
            // parse the id, only need the user's id at the end
            let user_id = droppable_id.substring(5);
            // get the id of the account/alias that was dragged into the droppable box
            let draggable_id = $(draggable).attr('id');

            // get an array of all account IDs in droppable box
            $(droppable).children().each(function() {
                children.push(this.id);
            });


            // check if the ID of dropped account against all account IDs already in droppable box
            if($.inArray(draggable.attr('id'), children) !== -1) {
                // dropped account is already in droppable
                // dont append the dropped account/alias to the droppable box
            } else {
                // dropped account is not in droppable
                // append the dropped account/alias to the droppable box
                let drag = $('.users').has(draggable).length ? draggable : draggable.clone().draggable({
                    snap: '.users',
                    stack: 'account_draggable',
                    cursor: 'move',
                    helper: 'clone',
                });
                drag.appendTo(droppable);
                // add the new user-account relationship to account_user table in db
                attachUserAliasPair(user_id, draggable_id);
            }

            
            droppedAccounts();
            

        }

        // For all account/alias names dropped inside droppable box
        // add the 'dropped' class to each appended account/alias name in div.users_alias_box
        // add the 'remove' class to each X next to account/alias name 
        // remove 'draggable_x_hidden' from X in order to display it
        function droppedAccounts() {
            $('.users_alias_box').children().each(function(index, item) {
                // Add 'dropped' class to accounts in droppable
                $(item).addClass('dropped');
                // Add 'remove' class to span tag for accounts in droppable
                $(item).children().addClass('remove');
                // Make span tag viewable in droppable
                $(item).children().removeClass('draggable_x_hidden');  
            });
        }


        // delete account-user association from account_user table
        function detachUserAliasPair(user_id, account_id){
            $.ajax({
                url: '/detach-user-account-pair',
                type: 'get',
                data: {user_id:user_id, account_id:account_id},
                dataType: 'json',
                success: function(data) {
                    // console.log(data.deleted_pair);
                    // console.log('user id: ', data.user_id);
                    // console.log('account id: ', data.account_id);
                    // console.log('result: ', data.result);

                }
            });
        }


        // add account-user association to account_user table
        function attachUserAliasPair(user_id, account_id){
            $.ajax({
                url: '/attach-user-account-pair',
                type: 'get',
                data: {user_id:user_id, account_id:account_id},
                dataType: 'json',
                success: function(data) {
                    // console.log(data.deleted_pair);
                    // console.log('user id: ', data.user_id);
                    // console.log('account id: ', data.account_id);
                    // console.log('result: ', data.result);

                }
            });
        }

    
        


    /**
    * =============================================================================== 
    * Get users when user types in search input
    * ===============================================================================
    */

        // get users when the user types in input search
        $(document).on('keyup', '#user_search', function(){
            query['search_users'] = $(user_search).val();
            users_live_search(query);
        });



    /**
    * =============================================================================== 
    * get and list out all account/alias names to be able to pair with users
    * ===============================================================================
    */

        get_all_accounts();


    /**
    * =============================================================================== 
    * Make account/alias names inside div#accounts_here draggable & hide their X
    * ===============================================================================
    */

        // Hide span X on draggable account/alias names in div#accounts_here
        $(account_draggable).each(function(index, item) {
            $(item).children().addClass('draggable_x_hidden');
        });

        // Make all account/alias names draggable inside div#accounts_here
        $('.account_draggable').draggable({
            snap: '.users',
            stack: 'account_draggable',
            cursor: 'move',
            helper: 'clone',
        });


    /**
    * =====================================================================================================================================
    * Remove account/alias name association with user
    * =====================================================================================================================================
    */

        // when user clicks on account/alias name thats inside droppable box
        $('#users_here').on('click', '.dropped', function() {
            let parent_id = $(this).parent().attr('id');
            let user_id = parent_id.substring(5);
            let acct_id = $(this).attr('id');

            detachUserAliasPair(user_id, acct_id);

            $(this).remove();
        });



    /**
    * =====================================================================================================================================
    * When User submits a new alias name, re-populate 'Pair User with Alias Names' section
    * =====================================================================================================================================
    */

        // $('#addAccountModal').on('click', '#submit_new_acct', function() {
        //     // console.log(this);
            
        //     // Get accounts/alias names
        //     $.ajax({
        //         'type': "get",
        //         'dataType': 'json',
        //         'url': "/get-accounts",
        //         'success': function (data) {
        //             // append all account/alias names to div#accounts_here
        //             $(accounts_here).empty();
        //             // $(accounts_here).html(data.user_pair_alias);
        //             // $(accounts_here).append(data.user_pair_alias);
        //             console.log(data.user_pair_alias);
        //         }
        //     });
        // });

        






});
