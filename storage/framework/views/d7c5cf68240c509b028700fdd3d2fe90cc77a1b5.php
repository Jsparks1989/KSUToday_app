<!-- JS for Alias Names/Accounts -->
<script>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


           /**
            * =============================================================================== 
            * Ajax Live Search Below This Line
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
                    error: function() {

                    }
                });
            }
            get_accounts();


           /**
            * =============================================================================== 
            * Display Category Modal Window
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
                        $('.current_account').val(data.output['name']);
                        $('.updated_account').attr('id', data.output['id']);
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
            * Close Category Modal Window
            * ===============================================================================
            */

            function closeModal() {
                let modal = $('#accountModal');
                modal.css({ display: "none" });
            }

            $(document).on('click', '.close', function(){
                closeModal();

            });

            
           /**
            * =============================================================================== 
            * Submit/Validate Category Edit Change
            * ===============================================================================
            */
            function validateCat(currentCat, updatedCat) {
                let currentVal = currentCat;
                let updatedVal = updatedCat;
                if(updatedVal) {
                    if(updatedVal != currentVal) {
                        document.getElementById('not_a_account_error').style.display='hidden';
                        return true;
                    } else {
                        document.getElementById('not_a_account_error').style.display='block';
                        document.getElementsByClassName('updated_account')[0].focus();
                        return false;
                    }
                } else {
                    document.getElementById('not_a_account_error').style.display='block';
                    document.getElementsByClassName('updated_account')[0].focus();
                    return false;
                }
            }

            function editCategory(id, value) {
                $.ajax({
                    url: '/edit-account/'+ id + '/' + value,
                    type: 'get',
                    // data: {query:query},
                    dataType: 'json',
                    success: function(data) {
                        console.log('data: ', data);
                        // $('.current_category').val(data.output['name']);
                        // $('.updated_category').attr('id', data.output['id']);
                        closeModal();
                        window.location.href = "<?php echo e(route('settings')); ?>";
                        //-- Need to be on 'Alias Names' tab when refresh --//
                    }
                }); 
            }

            $(document).on('click', '#submit_acct_change', function(){
                let acct_id = $('.updated_account').attr('id');
                let updated_acct = $('.updated_account').val();
                let current_acct = $('.current_account').val();
                
                //-- Validate the input
                
                if(validateCat(current_acct, updated_acct)) {
                    editCategory(acct_id, updated_acct);
                } 

                
            });
            


        });
    </script><?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-settings-js-accounts.blade.php ENDPATH**/ ?>