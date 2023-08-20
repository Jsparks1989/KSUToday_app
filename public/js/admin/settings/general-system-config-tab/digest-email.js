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

        // array of digest emails
        var digest_emails_arry = [];

        // set digest_emails_arry to all emails
        function set_digest_emails_arry(data) {
            digest_emails_arry = data;
        }

        // the domain for email that digest is sent to
        let approved_domain = 'kennesaw.edu';

        // select#digest_email_select
        let digest_email_select = $('#digest_email_select');

        // p#not_new_email_error
        let not_new_email_error = $('#not_new_email_error');

        // p#not_ksu_email_error
        let not_ksu_email_error = $('#not_ksu_email_error');

        // p.addDigestEmailModal_errors
        let addDigestEmailModal_errors = $('.addDigestEmailModal_errors');

        // div#addDigestEmailModal
        let addDigestEmailModal = $('#addDigestEmailModal');

        // input#new_digest_email_input
        let new_digest_email_input = $('#new_digest_email_input');

        // button#submit_new_digest_email
        let submit_new_digest_email = $('#submit_new_digest_email');

        // button#open_addDigestEmailModal
        let open_addDigestEmailModal = $('#open_addDigestEmailModal');

        // span.close
        let close_addDigestEmailModal = $('.close');
        
        // get all emails from digestEmail table and appends them to select#digest_email_select
        function populateEmailOptions() {
            $.ajax({
                url: '/get-digest-emails',
                type: 'get',
                dataType: 'json',
                success: function(data){
                    // console.log(data);
                    $(digest_email_select).empty();

                    let digest_emails = data.digest_emails;
                    let cron_job_email = data.cron_job_email[0];

                    $(digest_emails).each((key, value) => {

                        if(value['id'] == cron_job_email) {
                            $(digest_email_select).append($('<option>', {
                                value: 'digest_email_'+value['id'],
                                text: value['email'],
                                selected: 'selected'
                            }));
                        } else {
                            $(digest_email_select).append($('<option>', {
                                value: 'digest_email_'+value['id'],
                                text: value['email']
                            }));
                        }
                    });
                    // set digest_emails_arry to all emails
                    set_digest_emails_arry(data.digest_emails_arry);
                }, 
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }

        // add new email to digest_emails table
        function addDigestEmail(email) {
            return new Promise ((resolve, reject) => {
                $.ajax({
                    url: '/add-digest-email',
                    data: {email:email},
                    type: 'get',
                    dataType: 'json',
                    success: resolve, 
                    error: reject,
                });
            });
            
        }


        function updateCronJobDigest(email_id = '', time = '') {
            return new Promise ((resolve, reject) => {
                $.ajax({
                    url: '/update-cron-job-digest',
                    data: {email_id:email_id, time:time},
                    type: 'get',
                    dataType: 'json',
                    success: resolve, 
                    error: reject,
                });
            });
        }


        // (Promise) validate that input is a valid email with the right domain
        function validateEmail(inputText) {
            return new Promise ((resolve, reject) => {
                let mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                //-- get the domain from new email
                let domain = inputText.substring(inputText.lastIndexOf("@") +1);
    
                if(inputText.match(mailformat)) {
                    // resolve;
                    if(domain == approved_domain) {
                        // return true;
                        resolve(inputText);
                    } else {
                        // return false;
                        reject('was not valid email');
                    }
                } else {
                    // return false;
                    reject('was not valid email');
                }
            });
            
        }

        function checkIfNewDigestEmailExists(new_email) {
            return new Promise ((resolve, reject) => {
                // if new email does not already exist in digest_emails table
                if($.inArray(new_email, digest_emails_arry) == -1) {
                    // console.log('new email does NOT exist');
                    resolve(new_email);
                } else {
                    // console.log('new email DOES exist');
                    $(not_new_email_error).css('display', 'block');
                    reject('This email already exists in the digest_emails table ');
                }
            });
        }

        // display addDigestEmailModal
        function openModal() {
            $(addDigestEmailModal).css('display', 'block');
            $(addDigestEmailModal_errors).css('display', 'none');
            $(new_digest_email_input).val('');
            $(new_digest_email_input).focus();
        }

        // close addDigestEmailModal
        function closeModal() {
            $(addDigestEmailModal).css('display', 'none');
            $(addDigestEmailModal_errors).css('display', 'none');
            $(new_digest_email_input).val('');
            $(new_digest_email_input).focus();
        }

   


   /**
    * =============================================================================== 
    * Get all digest emails and append them to 
    * ===============================================================================
    */ 

        populateEmailOptions();


   /**
    * =============================================================================== 
    * Open/Close addDigestEmailModal
    * ===============================================================================
    */

        $(open_addDigestEmailModal).on('click', function() {
            openModal();
        });


        $(close_addDigestEmailModal).on('click', function() {
            closeModal();
        });
        



    /**
     * =============================================================================== 
     * Add a new email to digest_emails table
     * ===============================================================================
     */

        $(submit_new_digest_email).on('click', function() {
            $(addDigestEmailModal_errors).css('display','none');
            let new_email = $(new_digest_email_input).val();
            
            // validate that new_email is an email address with the KSU domain
            validateEmail(new_email).then((new_email) => {
                // The email entered does contain the KSU domain
                // Next, check if the email already exists in the digest_emails table
                $(addDigestEmailModal_errors).css('display','none');
                checkIfNewDigestEmailExists(new_email).then((new_email) => {
                    // The email entered is a valid KSU email and does not exist in digest_emails table
                    // Add the email to digest_emails table
                    console.log(new_email);

                    addDigestEmail(new_email).then((resolve) => {
                        closeModal();
                        populateEmailOptions();
                    }).catch((reject) => {
                        console.log(reject);
                        $(new_digest_email_input).focus();
                    });


                }).catch((reject) => {
                    // The email entered is a valid KSU email, but already resides in digest_emails table
                    console.log(reject);
                });
            }).catch((reject) => {
                // The email entered is NOT a valid email with the KSU domain
                $(new_digest_email_input).focus();
                $(not_ksu_email_error).css('display','block');

            });
            
        });

        
        

        
    /**
    * =============================================================================== 
    * Update Email for CronJobDigest
    * ===============================================================================
    */
        // when user changes the value of position or message for any of the toasts
        $(digest_email_select).on('change', function() {

            let new_cron_email_id = $(this).val().substring(13);
            console.log(new_cron_email_id);
            updateCronJobDigest(new_cron_email_id).then((resolve) => {
                // console.log(resolve);
            }).catch((reject) => {
                // console.log(reject);
            });
        });


        



});

        
    (function () { GLOBAL_scriptsLoaded.push( 'admin-moderate-users.js' ) })();