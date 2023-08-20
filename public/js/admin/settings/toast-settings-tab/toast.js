/* ==========================================================================
    JavaScript for admin-settings-toast.blade.php

    * Changing the position for each toast alert
    * Changing the message for each toast alert
    * Adding new message

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

        /**
        * =============================================================================== 
        * define global variables for toasts, positions, and messages
        * define functions to set global variables 
        * ===============================================================================
        */

            // all message objects from messages table
            var global_toast_messages;
            function set_global_toast_messages(data) {
                global_toast_messages = data;
            }

            // array of just the messages, not entire object
            var global_toast_messages_array;
            function set_global_toast_messages_array(data) {
                global_toast_messages_array = data;
            }

        //--------------------------------------------------------------------

            // all position objects from positions table
            var global_toast_positions;
            function set_global_toast_positions(data) {
                global_toast_positions = data;
            }

            // array of just the positions, not entire object
            var global_toast_positions_array;
            function set_global_toast_positions_array(data) {
                global_toast_positions_array = data;
            }

        //--------------------------------------------------------------------
            
            // all toast objects from toasts table
            var global_toasts;
            function set_global_toasts(data) {
                global_toasts = data;
            }

        //--------------------------------------------------------------------


        // select.toast_settings
        let toast_settings = $('.toast_settings');

        // button#open_message_modal
        let open_toast_modal_btn = $('#open_message_modal');

        // span.close
        let close_toast_modal_btn = $('.close');

        // button#submit_new_msg
        let toast_msg_submit_btn = $('#submit_new_msg');

        // div#add_message_modal
        let toast_msg_modal = $('#add_message_modal');

        // input#new_toast_message
        let toast_msg_input = $('#new_toast_message');

        // p#not_new_toast_message_error
        let toast_message_modal_error = $('#not_new_toast_message_error');


        // get all toasts, messages and positions
        function getAllToastData() {
            return new Promise ((resolve, reject) => {
                $.ajax({
                    url: '/get-all-toast-data',
                    type: 'get',
                    // data: {query:query},
                    dataType: 'json',
                    success: resolve,
                    error: function (request, status, error) {
                        alert(request.responseText);
                    }
                });
            });  
        }


        // Update toast in toasts table
        function updateToast(toast, setting, value) {
            console.log('value: ', value);
            console.log('setting: ', setting);
            console.log('toast: ', toast);
            $.ajax({
                url: '/update-toast',
                type: 'get',
                dataType: 'json',
                data: {toast: toast, setting:setting, value:value},
                success: function(data){
                    // console.log('update-toast data: ', data);
                },
                error: function (request, status, error) {
                    // alert(request.responseText);
                }
            });
        }

        // Add new toast message in messages table
        function addNewToastMessage(message) {
            $.ajax({
                url: '/add-new-toast-message',
                type: 'get',
                dataType: 'json',
                data: {message: message},
                success: function(data){

                }
            });
        }

        // populate toast positions & messages for each toast
        function populateToastOptions(positions, messages, toast, toast_position, toast_message) {
            // populating position
            $.each(positions, function(index, value) {
                // console.log(toast['position']['name']);
                if(toast['position']['name'] == value['name']) {
                    $(toast_position).append($('<option>').val(value['id']).text(value['name']).attr('selected', 'selected'));    
                } else {
                    $(toast_position).append($('<option>').val(value['id']).text(value['name']));
                }
            });
        
            // populating message
            $.each(messages, function(index, value) {
                if(toast['message']['message'] == value['message']) {
                    $(toast_message).append($('<option>').val(value['id']).text(value['message']).attr('selected', 'selected'));    
                } else {
                    $(toast_message).append($('<option>').val(value['id']).text(value['message']));
                }
            });
        
        }

        // open 'Add New Message' modal
        function openModal(id, input) {
            // get the modal
            let modal = $(id);
            $(modal).css('display', 'block');
            $(toast_message_modal_error).css('display', 'none');
            $(input).val('');
            $(input).focus();
        }

        // close 'Add New Message' modal
        function closeModal(id) {
            let modal = $(id);
            $(modal).css('display', 'none');
        }

        // validate new message before adding to messages table
        // new message cant be an existing message
        function validateToastMessage(msg_value, messages) {
            return new Promise ((resolve, reject) => {
                // console.log(msg_value);
                // console.log(messages);
                resolve(global_toast_messages_array.includes(msg_value));
            });
        }


    /**
    * =============================================================================== 
    * set all global_ toast variables, then populate each toast in blade file 
    * ===============================================================================
    */

        // Get all Toast data & set all global variables
        getAllToastData().then((resolve) => {
            set_global_toast_messages(resolve.messages);
            set_global_toast_messages_array(resolve.messages_array);
            set_global_toast_positions(resolve.positions);
            set_global_toast_positions_array(resolve.positions_array);
            set_global_toasts(resolve.toasts);


            /**
            * =============================================================================== 
            * Populate Toast Settings 
            * ===============================================================================
            */
            
                //-- CREATE POST 
                let create_post_position_select = $('#create_post_toast_position_select');
                let create_post_message_select = $('#create_post_toast_message_select');
                populateToastOptions(global_toast_positions, global_toast_messages, global_toasts[0], create_post_position_select, create_post_message_select);

                //-- UPDATE POST
                let update_post_position_select = $('#update_post_toast_position_select');
                let update_post_message_select = $('#update_post_toast_message_select');
                populateToastOptions(global_toast_positions, global_toast_messages, global_toasts[1], update_post_position_select, update_post_message_select);

                //-- CONTRIBUTOR
                let contributor_position_select = $('#contributor_toast_position_select');
                let contributor_message_select = $('#contributor_toast_message_select');
                populateToastOptions(global_toast_positions, global_toast_messages, global_toasts[2], contributor_position_select, contributor_message_select);

                //-- UPDATE USER
                let update_user_position_select = $('#update_user_toast_position_select');
                let update_user_message_select = $('#update_user_toast_message_select');
                populateToastOptions(global_toast_positions, global_toast_messages, global_toasts[3], update_user_position_select, update_user_message_select);


                //-- CREATE USER
                let create_user_position_select = $('#create_user_toast_position_select');
                let create_user_message_select = $('#create_user_toast_message_select');
                populateToastOptions(global_toast_positions, global_toast_messages, global_toasts[4], create_user_position_select, create_user_message_select);

        });


   /**
    * =============================================================================== 
    * Update Toast Settings 
    * ===============================================================================
    */
        // when user changes the value of position or message for any of the toasts
        $(toast_settings).on('change', function() {
            let select_id_array = $(this).attr('id').split('_');
            let toast_attribute;
            // if the select option that was changed includes 'position' in its id
            if(select_id_array.includes('position')) {
                toast_attribute = 'position_id';
            // if the select option that was changed includes 'message' in its id
            } else if(select_id_array.includes('message')) {
                toast_attribute = 'message_id';
            }

            let select_value = $(this).val();
            let toast_title = $(this).attr('name');        
            updateToast(toast_title, toast_attribute, select_value);
        });
 

    /**
     * =============================================================================== 
     * Display/Close 'Add Toast Message' Modal Window
     * ===============================================================================
     */

        
        // when user clicks 'Add Message' button
        $(open_toast_modal_btn).on('click', function() {
            openModal(toast_msg_modal, toast_msg_input);
        });

        
        // when user clicks the X in modal window
        $(close_toast_modal_btn).on('click', function() {
            closeModal(toast_msg_modal);
        });

        
    /**
     * =============================================================================== 
     * Submit/Validate 'Add Toast Message' Modal Submission
     * ===============================================================================
     */

        
        // when user submits new message to be added to messages table
        $(toast_msg_submit_btn).on('click', function() {
            let input_value = $(toast_msg_input).val();
            validateToastMessage(input_value, global_toast_messages).then((resolve) => {
                if(resolve = true) {
                    $(toast_msg_input).focus();
                    $(toast_message_modal_error).css('display', 'block');
                } else if(resolve = false) {
                    addNewToastMessage(input_value);
                    closeModal(toast_msg_modal);
                }
            });
        });


        

    

});
