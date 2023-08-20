<!-- ====================================================================================================== 
 * Categories tab under settings  
 
 * URL - APP_URL/settings

 * CHILD VIEW of - N/A 
    - included on admin-settings.blade.php
 
 
 * What page is doing:
    - editing current category names
    - adding new category names

 * Controller 
    - AjaxController@getCategoriesEdit() get all categories from categories table to be able to edit
        > route - /get-categories-edit
        
    - AjaxController@getCategory() get category user wants to edit and load into modal window
        > route - /get-category/{id}

    - AjaxController@editCategory() update category in categories table
        > route - /edit-category/{id}/{value}

    - AjaxController@addCategory() add new category to categories table
        > route - /add-category

    

 * JS file 
    - app/public/js/admin/settings/catgories-tab/categories.js

 * CSS file
    - 
====================================================================================================== -->


    <h2>Edit Categories</h2>
    
    <!-- where category names are loaded to be able to edit -->
    <div id="categories_list"></div>

    <!-- click to add a new category -->
    <button type="submit" class="btn search-btn" id="add_category">Add a Category</button>


    <!-- edit category modal -->
    <div id="editCategoryModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Edit Category Name:</h3>
            <input type="text" name="updated_category" class="updated_category"  placeholder="Enter New Category Name" />

            <p id="not_a_category_error" style="color:red; display:none;">Please enter a new category name.</p>    
            <button type="submit" class="btn search-btn" id="submit_cat_change">Submit</button>
        </div>

    </div>

    

    <!-- Add New Category Modal -->
    <div id="addCategoryModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Add New Category:</h3>
            <!-- <label for="roles">New Category:</label> -->
            <input type="text" name="new_category" class="new_category" placeholder="Enter New Category Name"/>

            <p id="not_new_category_error" style="color:red; display:none;">Please enter a new category name.</p>    
            <button type="submit" class="btn search-btn" id="submit_new_cat">Submit</button>
        </div>

    </div>









<?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/categories-tab/categories.blade.php ENDPATH**/ ?>