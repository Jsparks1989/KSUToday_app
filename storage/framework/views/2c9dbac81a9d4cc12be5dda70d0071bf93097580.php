







    <h2>Categories</h2>
    <div id="categories_list"></div>


    <button type="submit" class="btn search-btn" id="add_category">Add a Category</button>


    <!-- PUT MODAL HERE -->
    <!-- The Modal -->
    <div id="categoryModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Edit Category:</h3>
            <label for="roles">Current Category:</label>
            <input type="text" name="current_category" class="current_category" readonly='readonly'/>

            <label for="roles">Updated Category:</label>
            <input type="text" name="updated_category" class="updated_category"  placeholder="Enter New Category Name" />

            <p id="not_a_category_error" style="color:red; display:none;">Please enter a new category name.</p>    
            <button type="submit" class="btn search-btn" id="submit_cat_change">Submit</button>
        </div>

    </div>


    <div id="addCategoryModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Add Category:</h3>
            <label for="roles">New Category:</label>
            <input type="text" name="new_category" class="new_category" placeholder="Enter New Category Name"/>

            <p id="not_new_category_error" style="color:red; display:none;">Please enter a new category name.</p>    
            <button type="submit" class="btn search-btn" id="submit_new_cat">Submit</button>
        </div>

    </div>









<?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-settings-categories.blade.php ENDPATH**/ ?>