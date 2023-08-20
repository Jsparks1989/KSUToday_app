
/* ==========================================================================
    JavaScript for admin-settings-categories.blade.php

    * Adding new categories 
    * Editing current categories

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

            // initiate variable to hold all category names
            var cat_names;

            // set cat_names variable with all cateogry names
            function set_cat_names(data) {
                cat_names = data;
            }

            // input.new_category
            let new_category = $('.new_category');

            // div#addCategoryModal
            let addCategoryModal = $('#addCategoryModal');

            // p#not_new_category_error
            let not_new_category_error = $('#not_new_category_error');


            // div#editCategoryModal
            let editCategoryModal = $('#editCategoryModal');

            // p#not_a_category_error
            let not_a_category_error = $('#not_a_category_error');

            // input.updated_category
            let updated_category = $('.updated_category');

            // div#categories_list
            let categories_list = $('#categories_list');


            // get all categories 
            // append them to div#categories_list
            // set cat_names variable
            function get_categories(){
                $.ajax({
                    url: '/get-categories-edit',
                    type: 'get',
                    // data: {query:query},
                    dataType: 'json',
                    success: function(data) {
                        $(categories_list).html(data.output);
                        set_cat_names(data.category_names);
                    }
                });
            }

            // open 'edit category' modal with chosen category to edit
            function openModal(id) {
                $.ajax({
                    url: '/get-category/'+ id,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        $(updated_category).attr('id', data.output['id']);
                        $(updated_category).attr('placeholder', data.output['name']);
                        $(editCategoryModal).css({ display: "block" });
                        $(updated_category)[0].focus();
                        $(not_a_category_error).css('display','none');
                    }
                }); 
            }

            // close 'edit category' modal
            function closeModal() {
                $(updated_category).val('');
                $(editCategoryModal).css({ display: "none" });
                $(not_a_category_error).css({display: "hidden"});
            }

            // validate edited category
            // cant be empty string 
            // cant use a current category name
            function validateCat(updatedCat) {
                let category_input = $(updated_category).first();
                if(updatedCat) {
                    if(!cat_names.includes(updatedCat)) {
                        $(not_a_category_error).css({ display: "hidden" });
                        return true;
                    } else {
                        $(not_a_category_error).css({ display: "block" });
                        $(category_input).focus();
                        return false;
                    }
                } else {
                    $(not_a_category_error).css({ display: "block" });
                    $(category_input).focus();
                    return false;                
                }
            }


            // update the edited category in categories table
            // update the value of the edited category listed
            function editCategory(id, value) {
                $.ajax({
                    url: '/edit-category/'+ id + '/' + value,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        $('#category_'+id).text(data.value);
                        closeModal();
                    }
                }); 
            }


            // open the 'add category' modal
            function openAddCatModal() {
                $(not_new_category_error).css('display','none');  
                $(addCategoryModal).css({ display: "block" }); 
            }

            // close the 'add category' modal
            function closeAddCatModal() {
                $(new_category).first().val('');
                $(addCategoryModal).css({ display: "none" });
            }

            // add new category to categories table
            function addCategory(query) {
                $.ajax({
                    url: '/add-category',
                    type: 'get',
                    data: {query:query},
                    dataType: 'json',
                    success: function(data) {
                        get_categories();
                        closeAddCatModal()
                    }
                });
            }

            // new category cant be empty string
            // new category cant have the same name as an existing category
            function validateNewCat(newCat) {
                if(newCat) {
                    if(!cat_names.includes(newCat)) {
                        $(not_new_category_error).css('display','none');
                        return true;
                    } else {
                        $(not_new_category_error).css('display','block');
                        $(new_category)[0].focus();
                        return false;
                    }
                } else {
                    $(not_new_category_error).css('display','block');
                    $(new_category)[0].focus();
                    return false;                
                }
            }
    

        

        /**
        * =============================================================================== 
        * Get/Populate list of categories that can be edited 
        * ===============================================================================
        */
       
        
            get_categories();


        /**
        * =============================================================================== 
        * Open/Close 'Edit Category' Modal Window
        * ===============================================================================
        */

        
            // when user clicks on a category to edit
            $(categories_list).on('click', '.categories', function(){
                // parse the id of category and pass in just the number (category_3 -> 3)
                get_categories();
                let id = $(this).attr('id');
                id = id.substr(9);
                openModal(id);
            });


            
            // when user click on X in modal window
            $(document).on('click', '.close', function(){
                closeModal();
            });
        

        
        /**
        * =============================================================================== 
        * Submit/Validate Edited Category
        * ===============================================================================
        */
        
            // when user clicks on 'submit' button in Edit Category Modal
            $(document).on('click', '#submit_cat_change', function(){
                let cat_id = $(updated_category).attr('id');
                let updated_cat = $(updated_category).val();
                
                //-- Validate the input
                if(validateCat(updated_cat)) {
                    editCategory(cat_id, updated_cat);
                }   
            });
        


       /**
        * =============================================================================== 
        * Open/Close 'Add Category' Modal Window
        * ===============================================================================
        */

        
            // when user clicks 'add a category' button
            $(document).on('click', '#add_category', function(){
                openAddCatModal();
                $(new_category)[0].focus();
            });


            

            // when user clicks X in 'add category' modal
            $(document).on('click', '.close', function(){
                closeAddCatModal();

            });

        

        /**
        * =============================================================================== 
        * Submit/Validate New Category
        * ===============================================================================
        */

            // when user submits new category
            $(document).on('click', '#submit_new_cat', function(){
                let new_cat = $(new_category).first().val();
                if(validateNewCat(new_cat)) {
                    addCategory(new_cat);
                }
            });




    });
