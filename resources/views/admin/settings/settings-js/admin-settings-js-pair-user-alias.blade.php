


<!-- ==========================================================================
    JavaScript for Adding/Removing Alias Names/Accounts with Users

    Used for: admin-settings-pair-user-alias.blade.php
========================================================================== -->

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>



<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



           /**
            * =============================================================================== 
            * Ajax Live Search For Users to Pair Alias to
            * ===============================================================================
            */

            function users_live_search(query = ''){
                $.ajax({
                    url: '/search-users-pair-account',
                    type: 'get',
                    data: {query:query},
                    dataType: 'json',
                    success: function(data) {
                        // $('tbody').html(data.table_data);
                        $('#users_here').html(data.user_pair_alias);

                        // console.log('users:', data.user_data);
                        $('.users_alias_box').droppable({
                            accept: '.account_draggable',
                            drop: handleDropEvent,
                        });

                        droppedAccounts();
                    }
                });
            }

            // Gather the inputs.search_posts
            $(document).on('keyup', '#user_search', function(){
                let query = {
                    'search_users': '',

                };
                query['search_users'] = $("#user_search").val();
                users_live_search(query);
            });


            $('#roles').change(function() {
                let query = {
                    'search_users': '',
                    'role' : '',
                };

                query['search_users'] = $("#user_search").val();
                query['role'] = $('#roles').val();

                users_live_search(query);
            });



           /**
            * =============================================================================== 
            * Ajax get and list all accounts/ alias names
            * ===============================================================================
            */

            function get_all_accounts(){
                $.ajax({
                    'async': false,
                    'type': "get",
                    'global': false,
                    'dataType': 'json',
                    'url': "/get-accounts",
                    // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
                    'success': function (data) {
                        $('#accounts_here').html(data.user_pair_alias);

                        // console.log('users_accounts', data.users_accounts);
                    }
                })
            }

            get_all_accounts();


           /**
            * =============================================================================== 
            * Drag And Drop for adding alias names to users 
            * ===============================================================================
            */

            //---- Hide span X on draggable account
            $('.account_draggable').each(function(index, item) {
                $(item).children().addClass('draggable_x_hidden');
            });

            //-- Make all alias names draggable
            $('.account_draggable').draggable({
                snap: '.users',
                stack: 'account_draggable',
                cursor: 'move',
                helper: 'clone',
            });

            //---- Now I need to:
            //---- 1) make the account name stay in box (Make Account/Alias Names droppable). Also check to make sure there are no double draggables in droppables
            function handleDropEvent(event, ui) {
                let droppable = $(this);
                let draggable = ui.draggable;
                let children = [];


                let droppable_id = $(droppable).attr('id');
                let user_id = droppable_id.substring(5);
                let draggable_id = $(draggable).attr('id');


                // get an array of all account IDs in droppable  
                $(droppable).children().each(function() {
                    children.push(this.id);
                });


                // check if the ID of dropped account against all account IDs already in droppable
                if($.inArray(draggable.attr('id'), children) !== -1) {
                    //-- dropped account is already in droppable
                } else {
                    //-- dropped account is not in droppable
                    let drag = $('.users').has(draggable).length ? draggable : draggable.clone().draggable({
                        snap: '.users',
                        stack: 'account_draggable',
                        cursor: 'move',
                        helper: 'clone',
                    });
                    // adding dropped account to droppable div
                    drag.appendTo(droppable);
                    // attaching the account to the user in account_user table
                    attachUserAliasPair(user_id, draggable_id);
                }

                
                droppedAccounts();
                

            } //----- handleDropEvent()


           /**
            * =====================================================================================================================================
            * Add/Remove classes from Accounts that are in dropped div --> ran in onSuccess in Ajax call for users & when draggable is dropped
            * =====================================================================================================================================
            */
            function droppedAccounts() {
                $('.users_alias_box').children().each(function(index, item) {
                    var droppable_id = $(item).parent().attr('id');
                    // Add 'dropped' class to accounts in droppable
                    $(item).addClass('dropped');
                    // Add 'remove' class to span tag for accounts in droppable
                    $(item).children().addClass('remove');
                    // Make span tag viewable in droppable
                    $(item).children().removeClass('draggable_x_hidden');  
                });
            }


            //-- Run when user clicks on any accounts in droppable div
            $('#users_here').on('click', '.dropped', function() {
                let parent_id = $(this).parent().attr('id');
                let user_id = parent_id.substring(5);
                let acct_id = $(this).attr('id');
                let acct_text = $(this).text();

                detachUserAliasPair(user_id, acct_id);

                $(this).remove();
            });



           /**
            * =============================================================================== 
            * Ajax Detach account from user
            * ===============================================================================
            */

            function detachUserAliasPair(user_id, account_id){
                $.ajax({
                    url: '/detach-user-account-pair',
                    type: 'get',
                    data: {user_id:user_id, account_id:account_id},
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data.deleted_pair);
                        console.log('user id: ', data.user_id);
                        console.log('account id: ', data.account_id);
                        console.log('result: ', data.result);

                    }
                });
            }



           /**
            * =============================================================================== 
            * Ajax Attach account to user
            * ===============================================================================
            */

            function attachUserAliasPair(user_id, account_id){
                $.ajax({
                    url: '/attach-user-account-pair',
                    type: 'get',
                    data: {user_id:user_id, account_id:account_id},
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data.deleted_pair);
                        console.log('user id: ', data.user_id);
                        console.log('account id: ', data.account_id);
                        console.log('result: ', data.result);

                    }
                });
            }

            
      
            //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
            //----  LEFT OFF HERE --->>> Need to figure out how to remove/delete the draggables from droppable. Possible solution would be to include an <span>&times;</span> onclick to remove 
            //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


            
            //---- 2) add event that checks if an account as been added to user's box & use ajax to grab the accounts in user's box and update the user's account list column in users table
            //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
            //---- Make a new DB table. Many-to-many table that links users with alias names 
            //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

            // Next:
            //---- 3) add a account_list column to each user, this is where their approved account name id's will be added 
            //---- 4) when a user is being searched, populate the user's box with account names already attached (Do this in /live-search-users ajax)
            //---- 5) attach draggable jquery to the current accaount names that user's have

            // Next:
            //---- 6) Add event that checks if account has been removed from users box and update the users account list column
            
            
    
    });
</script>