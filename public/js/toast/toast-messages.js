
/*
    To Make More Toast Messages:
        1. Add a new session components.sessions.blade.php
        2. Add include('components.sessions') to blade file where Toast will be displayed
        3. Add session()->flash('the_session_name', 'the_session_message'); to Controller method that interacts with the blade.file

        ADD TO THIS JS FILE 
        4. Add new toast function that takes toast attributes as parameters
        5. Add new variable equal to id of the div that is temporarily displayed by session
        6. Add new if() that checks if div exists
        7. If div exists, run toast function 

*/



/*
    TO MAKE A NEW TOAST
        1. Add a new session to components.sessions.blade.php (session thats specifically for the new toast)
        2. Add "include('components.sessions')" to the blade file that the new Toast will be displayed
        3. Add session()->flash('the_session_name', 'the_session_message'); to Controller method that interacts with the blade.file
            ex. want a toast in admin settings page -> AdminController@adminSettings()
        
        ADD TO THIS JS FILE


*/



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
            // initialize toasts_array
            let toasts_array = null;

            // set toasts_array variable
            function setToasts(data) {
                toasts_array = data.toasts_arry;
            }
            
            // get all toasts and their message & position
            function getToasts() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: '/get-toasts',
                        type: 'get',
                        dataType: 'json',
                        success: resolve
                    });
                });
                
            }





            // get all toasts, then 
            getToasts().then(resolve => {
                setToasts(resolve);


                //-- When new post is created
                let $toast_created_success = $('#post_created_success');
                if($toast_created_success.length) {
                    // console.log('80: ', toasts_array);
                    successNewPostToast();
                    // console.log('success');
                }


                //-- Run Update Post Toast
                //-- if div#post_updated_success exists, display toast
                let $post_updated_success = $('#post_updated_success');
                if($post_updated_success.length) {
                    successUpdatePostToast();
                    // console.log('success');
                }

                //-- Run Contributor Toast 
                let $contributor_added_success = $('#contributor_created_success');
                if($contributor_added_success.length) {
                    successAddNewContributor();
                    // console.log(toasts_array);
                    // console.log('success contrib added');
                }

                //-- When admin creates new user
                let $user_created_success = $('#user_created_success');
                if($user_created_success.length) {
                    // console.log('80: ', toasts_array);
                    successCreateUserToast();
                    // console.log('success');
                }
            });




    /**
     * =============================================================================== 
     * TOAST FUNCTIONS
     * ===============================================================================
     */

        /**
         * ============================================================
         * Create Post | LOCATIONS: create-post blades
         * ============================================================
         */

            function successNewPostToast(message = toasts_array['create post'].message, title = '', setting = toasts_array['create post'].position) { 
                toastr.success(message, title, {
                    positionClass: setting,
                });
            }


        /**
         * ============================================================
         * Moderate Post | LOCATIONS: moderate-posts blades
         * ============================================================
         */

            function successUpdatePostToast(message = toasts_array['update post'].message, title = '', setting = toasts_array['update post'].position) {
                toastr.success(message, title, {
                    positionClass: setting,
                });
            }

            //-- if user updates post state, display toast
            $("#dynamic_content").on('change', '.post_status_select', function(){
                successUpdatePostToast();
                console.log('success');
            });


        /**
         * =============================================================== 
         * Add/Edit Contributors | LOCATIONS: moderate-contributors blades
         * ===============================================================
         */
            //-- moderator-add-contributors.blade.php
            function successAddNewContributor(message = toasts_array['contributor'].message, title = '', setting = toasts_array['contributor'].position) {
                toastr.success(message, title, {
                    positionClass: setting,
                });
            }


        /**
         * =========================================================================
         * Add/Edit Users | LOCATIONS: moderate-users blades for moderatator & admin
         * ============================================================
         */


            function successUpdateUserToast(message = toasts_array['update user'].message, title = '', setting = toasts_array['update user'].position) {
                toastr.success(message, title, {
                    positionClass: setting,
                });
            }

            function successCreateUserToast(message = toasts_array['create user'].message, title = '', setting = toasts_array['create user'].position) {
                toastr.success(message, title, {
                    positionClass: setting,
                });
            }

            //-- admin-add-users.blade.php
            //-- if user updates user role, display toast
            $("#dynamic_content").on('change', '.user_role_select', function(){
                console.log('update user: ', toasts_array['update user'].message);
                successUpdateUserToast();
            });

    });

    



    (function () { GLOBAL_scriptsLoaded.push( 'toast-messages.js' ) })();