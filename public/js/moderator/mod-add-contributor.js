

$(document).ready(function(){

    // Setting up ajax
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

        // current user's information
        // used throughout file to validate
        let currentUser = {
            id: '',
            role_id: '',
            name: '',
            email: '',
        }

        // query to send with ajax calls
        let search_contributors_query = {
            'search_contributors': ''
        };

        // tbody#contributor_list
        let contributor_list = $('#contributor_list');

        // div#pagination
        let pagination = $('#pagination');

        // div#myModal
        let modal = $('#myModal');

        // p#not_ksu_email_error
        let not_ksu_email_error = $('#not_ksu_email_error');

        // p#not_users_email_error
        let not_users_email_error = $('#not_users_email_error');

        // p#not_admins_email_error
        let not_admins_email_error = $('#not_admins_email_error');

        // input#new_contrib_email
        let new_contrib_email = $('#new_contrib_email');

        let allowed_domain = 'kennesaw.edu';

        // button#open_add_contrib_modal
        let open_add_contrib_modal = $('#open_add_contrib_modal');

        // button#add_contributor
        let add_contributor = $('#add_contributor');

        // span.close
        let close = $('.close');


        // Make sure both toastr.js & toast-messages.js are loaded
        let toastr = "toastr.js";
        let toast_messages = "toast-messages.js";
        if(GLOBAL_scriptsLoaded.includes(toastr) && GLOBAL_scriptsLoaded.includes(toast_messages)) {
            // console.log('has both');
        }


        // assign currentUser values
        // ran in getCurrentUserData() ajax
        function assignUser(user) {
            currentUser.id = user.id;
            currentUser.role_id = user.role_id;
            currentUser.name = user.name;
            currentUser.email = user.email;
        }

        // ajax call to retrieve the current user's data
        // assigns user's data to currentUser
        function getCurrentUserData() {
            $.ajax({
                url: '/get-current-user',
                type: 'get',
                // data: {query:query},
                dataType: 'json',
                success: function(data) {
                    assignUser(data.currentUser);                    
                }
            });
        }

        
        // load contributors and pagination
        // contributors retrieved depends on query & pagination page the user is on
        // retrieves all contributors if query is empty
        function contributors_live_search(page, query = ''){
            $.ajax({
                url: '/live-search-contributors',
                type: 'get',
                dataType:'json',
                data:{page:page, query:query},
                success: function(data) {
                    $(contributor_list).html(data.table);
                    $(pagination).html(data.pagination);
                }
            });
        }


        // Check if modal input is the current user's email
        function notUsersEmail(email, currentUser) {
            if(email != currentUser.email) {
                return true;
            } else {
                return false;
            }
        }


        // make sure the email entered by user in modal does not belong to an admin
        // return true/false in promise
        function checkModAndAdminEmail(email) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: '/check-admin-email',
                    type: 'get',
                    data: {email:email},
                    dataType: 'json',
                    success: function(data) {
                        console.log('data: ', data); 
                        resolve(data.isAdminOrMod);
                    },
                    error: function (request, status, error) {
                        alert(request.responseText);
                    }
                });
            });
            
        }


        // Check if modal email input is a valid email address
        function validateEmail(inputText) {
            let mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if(inputText.match(mailformat)) {
                return true;
            } else {
                return false;
                
            }
        }

        /*
           runs validation functions to make sure the modal input email is:
           1. a valid email
           2. a ksu faculty/staff email
           3. not an admin email
           4. not current user's email
        */
        function submitNewContributor() {

            //-- get the email from input
            let email = $(new_contrib_email).val();

            //-- get the 'name' from email        
            let netID = email.substr(0, email.indexOf("@"));

            //-- get the domain from email
            let domain = email.substring(email.lastIndexOf("@") +1);

            // validate that what is entered is a valid email address
            if(validateEmail(email)) {
                if(domain == allowed_domain) {

                    if(notUsersEmail(email, currentUser)) {
                        console.log(email);
                        checkModAndAdminEmail(email).then((resolve) => {
                            console.log(email);
                            if(!resolve) {
                                console.log(email);
                                let query = {
                                    'name' : netID,
                                    'email' : email
                                }

                                $.ajax({
                                    url: '/add-contributor',
                                    type: 'get',
                                    data: {query:query},
                                    dataType: 'json',
                                    success: function(data) {
                                        console.log('data:', data);  
                                    }
                                });
                                closeModal();
                                location.reload();

                            } else {
                                $(not_ksu_email_error).css('display','none');
                                $(not_users_email_error).css('display','none');
                                $(not_admins_email_error).css('display','block');
                                $(new_contrib_email).focus();
                            }
                        });
                    } else {
                        $(not_admins_email_error).css('display','none');
                        $(not_ksu_email_error).css('display','none');
                        $(not_users_email_error).css('display','block');
                        $(new_contrib_email).focus();
                    }
                } else {
                    $(not_users_email_error).css('display','none');
                    $(not_admins_email_error).css('display','none');
                    $(not_ksu_email_error).css('display','block');
                    $(new_contrib_email).focus();
                }
            } else {
                $(not_users_email_error).css('display','none');
                $(not_admins_email_error).css('display','none');
                $(not_ksu_email_error).css('display','block');
                $(new_contrib_email).focus();
            }
        
        }


        // open the 'Add a Contributor' modal
        function openModal() {
            // get the modal
            $(modal).css('display','block');
            $(new_contrib_email).focus();
            $(new_contrib_email).val('');
            $(not_users_email_error).css('display','none');
            $(not_admins_email_error).css('display','none');
            $(not_ksu_email_error).css('display','none');
        }


        // close the 'Add a Contributor' modal
        function closeModal() {
            $(modal).css('display','none');
        }


    /**
    * =============================================================================== 
    * Get current user data and set it to currentUser variable
    * ===============================================================================
    */

        getCurrentUserData();
        // console.log('currentUser: ', currentUser);


   /**
    * =============================================================================== 
    * Display & Search Contributors
    * ===============================================================================
    */

        // Get all contributors when page loads,
        contributors_live_search(1);
        
        // Return contributors when user enters search
        $(document).on('keyup', '.search_my_posts', function(){
            search_contributors_query['search_contributors'] = $("#contributors_search").val();
            contributors_live_search(1, search_contributors_query);
        });


        // Return contributors when user enters search and chooses pagination page 
        $(document).on('click', '.page_link', function(){
            let page = $(this).data('page_number');
            search_contributors_query['search_contributors'] = $("#contributors_search").val();
            contributors_live_search(page, search_contributors_query);
        });



   /**
    * =============================================================================== 
    * Open/Close 'Add a Contributor' Modal
    * ===============================================================================
    */
        
        // user clicks on button#open_add_contrib_modal
        $(open_add_contrib_modal).on('click', function() {
            openModal();
        });  

        

        // user clicks on span#close
        $(close).on('click', function() {
            closeModal();
        }); 

        
   /**
    * =============================================================================== 
    * Add New Contributor
    * ===============================================================================
    */
    
        // user clicks on button#add_contributor in modal
        $(add_contributor).on('click', function() {
            submitNewContributor();
        });

});


    (function () { GLOBAL_scriptsLoaded.push( 'mod-add-contributor.js' ) })();