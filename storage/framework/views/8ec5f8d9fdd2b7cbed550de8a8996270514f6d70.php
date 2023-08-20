<!-- JS for categories -->
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
        * =============================================================================== 
        * Grabbing All Category Names && Account (Alias) Names
        * ===============================================================================
        */
        var cat_names;
        $.ajax({
            'async': false,
            'type': "get",
            'global': false,
            'dataType': 'json',
            'url': "/get-categories",
            // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
            'success': function (data) {
                cat_names = data.category_names;
            }
        });

// console.log(cat_names);


        /**
        * =============================================================================== 
        * Ajax Live Search Below This Line
        * ===============================================================================
        */

        function get_categories(){
            $.ajax({
                url: '/get-categories-edit',
                type: 'get',
                // data: {query:query},
                dataType: 'json',
                success: function(data) {
                    // $('tbody').html(data.table_data);
                    $('#categories_list').html(data.output);
                    // $('#total_records').text(data.total_data);
                    // console.log('data', data);

                },
                error: function() {

                }
            });
        }
        get_categories();


        /**
        * =============================================================================== 
        * Open/Close Edit Category Modal Window
        * ===============================================================================
        */

        function openModal(id) {
            $.ajax({
                url: '/get-category/'+ id,
                type: 'get',
                // data: {query:query},
                dataType: 'json',
                success: function(data) {
                    // console.log('category data', data.output);
                    $('.current_category').val(data.output['name']);
                    $('.updated_category').attr('id', data.output['id']);
                    var modal = $('#categoryModal');
                    modal.css({ display: "block" });

                    document.getElementsByClassName('updated_category')[0].focus();
                    document.getElementById('not_a_category_error').style.display='none';
                }
            }); 
        }

        $('#categories_list').on('click', '.categories', function(){
            openModal($(this).attr('id'));
        });


        function closeModal() {
            $('input.updated_category').val('');
            $('#categoryModal').css({ display: "none" });
            $('#not_a_category_error').css({display: "hidden"});
        }

        $(document).on('click', '.close', function(){
            closeModal();

        });
        

        
        /**
        * =============================================================================== 
        * Submit/Validate Category Edit Change
        * ===============================================================================
        */
        function validateCat(updatedCat) {
            let not_category_error = $('#not_a_category_error');
            let category_input = $('.updated_category').first();
            if(updatedCat) {
                if(!cat_names.includes(updatedCat)) {
                    not_category_error.css({ display: "hidden" });
                    return true;
                } else {
                    not_category_error.css({ display: "block" });
                    category_input.focus();
                    return false;
                }
            } else {
                not_category_error.css({ display: "block" });
                category_input.focus();
                return false;                
            }
        }

        function editCategory(id, value) {
            $.ajax({
                url: '/edit-category/'+ id + '/' + value,
                type: 'get',
                // data: {query:query},
                dataType: 'json',
                success: function(data) {
                    console.log('data: ', data);
                    closeModal();
                    window.location.href = "<?php echo e(route('settings')); ?>";
                    //-- Need to be on 'Categories' tab when refresh --//
                    //-- input#tab1 needs to be checked --//
                    $('#tab1').prop('checked', true);
                }
            }); 
        }

        $(document).on('click', '#submit_cat_change', function(){
            let cat_id = $('.updated_category').attr('id');
            let updated_cat = $('.updated_category').val();
            
            //-- Validate the input
            
            if(validateCat(updated_cat)) {
                editCategory(cat_id, updated_cat);
            }   
        });
        


       /**
        * =============================================================================== 
        * Open/Close Add Category Modal Window
        * ===============================================================================
        */

        function openAddCatModal() {
            document.getElementById('not_new_category_error').style.display='none';
            $('#addCategoryModal').css({ display: "block" }); 
        }

        $(document).on('click', '#add_category', function(){
            openAddCatModal();
            document.getElementsByClassName('new_category')[0].focus();
        });


        function closeAddCatModal() {
            $('.new_category').first().val('');
            $('#addCategoryModal').css({ display: "none" });
        }

        $(document).on('click', '.close', function(){
            closeAddCatModal();

        });

        

        /**
        * =============================================================================== 
        * Submit/Validate New Category
        * ===============================================================================
        */

        function addCategory(query) {
            $.ajax({
                url: '/add-category',
                type: 'get',
                data: {query:query},
                dataType: 'json',
                success: function(data) {
                    console.log('data:', data.query);
                    window.location.href = "<?php echo e(route('settings')); ?>";
                    //-- Need to be on 'Categories' tab when refresh --//
                    //-- input#tab1 needs to be checked --//

                    $('#tab1').prop('checked', true);
                }
            });

        }

        function validateNewCat(newCat) {
            if(newCat) {
                if(!cat_names.includes(newCat)) {
                    document.getElementById('not_new_category_error').style.display='hidden';
                    return true;
                } else {
                    document.getElementById('not_new_category_error').style.display='block';
                    document.getElementsByClassName('new_category')[0].focus();
                    return false;
                }
            } else {
                document.getElementById('not_new_category_error').style.display='block';
                document.getElementsByClassName('new_category')[0].focus();
                return false;                
            }
        }

        $(document).on('click', '#submit_new_cat', function(){
            let new_cat = $('.new_category').first().val();
            console.log(new_cat);

            if(validateNewCat(new_cat)) {
                addCategory(new_cat);
            }
        });




    });
</script><?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-settings-js-categories.blade.php ENDPATH**/ ?>