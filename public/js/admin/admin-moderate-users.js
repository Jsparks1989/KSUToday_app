

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

        

        // tbody#users_list
        let users_list =  $('#users_list');

        // div#pagination
        let pagination = $('#pagination');

        // div#dynamic_content
        let dynamic_content = $('#dynamic_content');

        // input#user_search
        let user_search = $("#user_search");

        // select#roles
        let roles = $('#roles');

        // p#EUE_not_ksu_email_error
        let EUE_not_ksu_email_error = $('#EUE_not_ksu_email_error');

        // p#EUE_email_exists_error
        let EUE_email_exists_error = $('#EUE_email_exists_error');


        // p#not_ksu_email_error
        let not_ksu_email_error = $('#not_ksu_email_error');

        // p#email_exists_error
        let email_exists_error = $('#email_exists_error');

        // input#new_user_email
        let new_user_email = $('#new_user_email');

        // select#roles_select
        let roles_select = $('#roles_select');

        // div#myModal Add New User Modal
        let newUserModal = $('#myModal');

        // button#add_user
        let add_user = $('#add_user');

        // button#open_add_user_modal
        let open_add_user_modal = $('#open_add_user_modal');

        // a#open_edit_user_netID_modal
        let open_edit_user_netID_modal = $('#open_edit_user_netID_modal');

        //span.close
        let close = $('.close');

        let allowed_domain = 'kennesaw.edu';

        let allowed_student_domain = 'students.kennesaw.edu';

        // query sent with ajax to search/display users
        let query = {
            'search_users': '',
            'role' : '',
        };

        // get/display users
        function users_live_search(page, query = ''){
            $.ajax({
                url: '/live-search-users',
                type: 'get',
                dataType:'json',
                data:{page:page, query:query},
                success: function(data) {
                    $(users_list).html(data.table);
                    $(pagination).html(data.pagination);
                }
            });
        }

        // update user's role
        function update_user_role(id, role) {
            $.ajax({
                url: '/update-user-role/' + id + '/' + role,
                type: 'get',
                dataType: 'json',
                success: function(response){
                    // console.log('response: ', response);
                }
            });
        }

        // validate email entered when adding user
        function validateEmail(inputText) {
            let mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if(inputText.match(mailformat)) {
                return true;
            } else {
                return false;
                
            }
        }

        // check if entered user email already exists in user table
        function checkIfUserExists(netID) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: '/check-user-exists',
                    type: 'get',
                    data: {netID:netID},
                    dataType: 'json',
                    success: function(data) {
                        console.log('data: ', data); 
                        // resolve(data.userExists);
                    }
                });
            });
        }

        // Check the user email input from modal and submit new user
        function submitNewUser() {
            $(not_ksu_email_error).css('display','none');
    
            //-- get the email from input
            // let email = document.getElementById('new_user_email').value;
            let email = $(new_user_email).val();
    
            //-- get the 'name' from email        
            let netID = email.substr(0, email.indexOf("@"));
    
            //-- get the domain from email
            let domain = email.substring(email.lastIndexOf("@") +1);
    
            let new_user_role = $(roles_select).val();
    
    
            // validate that what is entered is a valid email address
            if(validateEmail(email)) {
                if(domain == allowed_domain || domain == allowed_student_domain) {
                    // console.log(netID);
                    checkIfUserExists(netID).then((resolve) => {
                        if(!resolve) {
    
                            let query = {
                                'name' : netID,
                                'email' : email,
                                'role_id' : new_user_role,
                            }
    
                            $.ajax({
                                url: '/add-user',
                                type: 'get',
                                data: {query:query},
                                dataType: 'json',
                                success: function(data) {
                                    console.log('data:', data);
                                    // window.location.href = "{{ route('moderate-users')}}";
                                }
                            });
    
                            closeModal();
                            location.reload();
    
                        } else {
                            $(not_ksu_email_error).css('display','none');
                            $(email_exists_error).css('display','block');
                            $(new_user_email).focus();
                        }
                    });
    
                } else {
                    $(not_ksu_email_error).css('display','block');
                    $(email_exists_error).css('display','none');
                    $(new_user_email).focus();
                }
            } else {
                $(not_ksu_email_error).css('display','block');
                $(email_exists_error).css('display','none');
                $(new_user_email).focus();
            }
    
        }

        // open add new user modal
        function openModal() {
            $(newUserModal).css('display','block');
            $(new_user_email).focus();
            $(not_ksu_email_error).css('display','none');
        }

        // close add new user modal
        function closeModal() {
            $(newUserModal).css('display','none');
        }




        // div#edit_user_email_modal
        let edit_user_email_modal = $('#edit_user_email_modal');

        // input#edit_user_email
        let edit_user_email = $('#edit_user_email');

        // button#edit_user_email_submit
        let edit_user_email_submit = $('#edit_user_email_submit');

        let old_email;




        // Check the user email input from modal and submit new user
        function submitEditedEmail() {
            // set error msgs to none
            $(not_ksu_email_error).css('display','none');

            // original email
            let original_email = old_email;

            // updated email
            let updated_email = $(edit_user_email).val();

            //-- get the 'name' from email        
            let updated_netID = updated_email.substr(0, updated_email.indexOf("@"));

            //-- get the 'name' from email        
            let original_netID = original_email.substr(0, original_email.indexOf("@"));
    
            //-- get the domain from email
            let domain = updated_email.substring(updated_email.lastIndexOf("@") +1);
          
            // validate that what is entered is a valid email address
            if(validateEmail(updated_email)) {
                if(domain == allowed_domain || domain == allowed_student_domain) {
    
                    checkIfUserExists(updated_netID).then((resolve) => {
                        if(!resolve) {
    
                            let query = {
                                'original_email' : original_email,
                                'updated_email' : updated_email,
                                'updated_netID' : updated_netID,
                                'domain' : domain,
                                'original_netID' : original_netID,
                            }
    
                            $.ajax({
                                url: '/edit-user',
                                type: 'get',
                                data: {query:query},
                                dataType: 'json',
                                success: function(data) {
                                    console.log('data:', data);
                                    // window.location.href = "{{ route('moderate-users')}}";
                                },
                                error: function (request, status, error) {
                                    // alert(request.responseText);
                                }
                            });
    
                            closeEditUserEmailModal();
                            location.reload();
    
                        } else {
                            $(EUE_not_ksu_email_error).css('display','none');
                            $(EUE_email_exists_error).css('display','block');
                            $(edit_user_email).focus();
                        }
                    });
    
                } else {
                    $(EUE_not_ksu_email_error).css('display','block');
                    $(EUE_email_exists_error).css('display','none');
                    $(edit_user_email).focus();
                }
            } else {
                $(EUE_not_ksu_email_error).css('display','block');
                $(EUE_email_exists_error).css('display','none');
                $(edit_user_email).focus();
            }
    
        }



        // open edit user email & netID modal
        function openEditUserEmailModal(email) {
            $(edit_user_email_modal).css('display','block');
            $(edit_user_email).attr("placeholder", email);
            $(edit_user_email).focus();
            $(not_ksu_email_error).css('display','none');
        }

        // close edit user email & netID modal
        function closeEditUserEmailModal() {
            $(edit_user_email_modal).css('display','none');
            $(edit_user_email).val('');
        }



        // div#edit_user_email_modal
        let delete_use_email_modal = $('#delete_user_modal');


        // button#edit_user_email_submit
        let delete_user_email_submit = $('#delete_user_email_submit');

        // span#user_email
        let user_email_to_delete = $('#user_email');


        // button#delete_user_submit
        let delete_user_submit = $('#delete_user_submit');


        // open delete user modal
        function openDeleteUserModal(user_id, user_email) {
            $(delete_use_email_modal).css('display','block');
            // $(edit_user_email).attr("placeholder", email);
            $(user_email_to_delete).text(user_email);
            $(delete_user_submit).val(user_id);
        }

        

        // close delete user modal
        function closeDeleteUserModal() {
            $(delete_use_email_modal).css('display','none');
        }



        function deleteUser(user_id) {
            return new Promise ((resolve, reject) => {
                $.ajax({
                    url: '/delete-user',
                    type: 'get',
                    data: {user_id:user_id},
                    dataType: 'json',
                    success: function(data) {
                        console.log('data: ', data); 
                        resolve(data.user_deleted);
                    },
                    error: function (request, status, error) {
                        // alert(request.responseText);
                    }
                });
            });
        }
        

   /**
    * =============================================================================== 
    * Open/Close Add User Modal
    * ===============================================================================
    */ 

        $(close).click(function() {
            closeModal();
            closeEditUserEmailModal();
            closeDeleteUserModal()
        });

        $(open_add_user_modal).click(function() {
            openModal();
        });


   /**
    * =============================================================================== 
    * Display users
    * ===============================================================================
    */

        // display users immediately
        users_live_search(1);


        // display users based on search input
        $(document).on('keyup', '.search_my_posts', function(){
            query['search_users'] = $(user_search).val();
            query['role'] = $(roles).val();
            users_live_search(1, query);
        });


        // display users based on role search and input search
        $(roles).change(function() {
            query['search_users'] = $(user_search).val();
            query['role'] = $(roles).val();
            users_live_search(1, query);
        });


        // When user clicks li.page-item > a.page-link in pagination
        $(document).on('click', '.page_link', function(){
            let page = $(this).data('page_number');
            query['search_users'] = $('#user_search').val();
            query['role'] = $(roles).val();   
            users_live_search(page, query);
        });



    /**
     * =============================================================================== 
     * Edit post_state of post onchange()
     * ===============================================================================
     */

        $(dynamic_content).on('change', '.user_role_select', function(){
            let role = $(this).val();
            let id = $(this).prop('id');
            update_user_role(id, role);
        });




    /**
    * =============================================================================== 
    * Submit new user
    * ===============================================================================
    */


        $(add_user).on('click', function() {
            submitNewUser();
        });


    /**
    * =============================================================================== 
    * Open Edit User's Email & netID modal
    * ===============================================================================
    */

        $(dynamic_content).on('click', '.open_edit_user_email_modal', function(){
            let email = $(this).text();
            old_email = email;
            openEditUserEmailModal(email);
            
        });


    /**
    * =============================================================================== 
    * Submit Edited User's Email
    * ===============================================================================
    */

        $(edit_user_email_submit).on('click', function() {
            submitEditedEmail();
        });
        

    /**
    * =============================================================================== 
    * Delete User
    * ===============================================================================
    */

     $(dynamic_content).on('click', '.open_delete_user_modal', function(){
        let user = $(this).attr('id');
        user = user.split(' ');
        let user_id = user[0];
        let user_email = user[1];
        // console.log('user id: ', user_id);
        // console.log('user email: ', user_email);
        // openEditUserEmailModal(email);
        openDeleteUserModal(user_id, user_email);
    });


    $(delete_user_submit).click(function() {
        // console.log(this);
        let delete_user_id = $(this).val();
        // console.log(delete_user_id);
        deleteUser(delete_user_id).then((resolve) => {
            // console.log('asdasd', resolve);
            closeDeleteUserModal();
            users_live_search(1);
        });
    });

});

        
    (function () { GLOBAL_scriptsLoaded.push( 'admin-moderate-users.js' ) })();