<!-- ====================================================================================================== 
 * Admin add users view   
 
 * URL - APP_URL/moderate-users

 * CHILD VIEW of - admin.admin-master      
 
 * What page is doing:
    - shows all users
    - can create a new user
    - can edit user roles
    - can search users

 * Controller 
    - PageController@moderateContributors -> AdminController@moderateUsers()
        > route - /moderate-users

    - AjaxController@liveSearchUsers() populate tbody & search users 
        > route - /live-search-contributors

    - AjaxController@addUser() when new user is added
        > route - /add-user

    - AjaxController@editUserRole() when users role is updated
        > route - /update-user-role/{id}/{role}

 * JS file 
    - app/public/js/admin/admin-moderate-users.js
    - app/public/js/toast/toastr.js
    - app/public/js/toast/toast-messages.js

 * CSS file
    - 
 ====================================================================================================== -->






<!-- yield from admin-master.blade.php -->
<?php $__env->startSection('admin-js-scripts'); ?>
    <script src="<?php echo e(asset('js/admin/admin-moderate-users.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<!-- yield from admin-master.blade.php -->
<?php $__env->startSection('admin-css-styles'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('main'); ?>

    <?php echo $__env->make('components.sessions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <h1>Moderate Users</h1>


    <div class="container-box">
        <label for="title_summary">Search users by netID:</label>
        <input type="text" name="user_search" class="search_my_posts" id="user_search" placeholder="Search" />

        <!-- Roles -->
        <label for="roles">Roles:</label>
        <select name="roles_select" id="roles">
                <option name="role_item" id="role" value="0" selected>- All Roles -</option>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option name="role_item" id="role" value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

    </div>


    <button id="open_add_user_modal" class="btn search-btn">Add User</button>
    <!-- <button id="open_edit_user_netID_modal" class="btn search-btn">Edit User NetID</button> -->

    <div id="dynamic_content">
        <table class="table">
            <thead>
                <tr>
                    <th>netID</th>
                    <th>Edit Email</th>
                    <th>Role</th>
                    <th class="mu-hide">Last Login At</th>
                    <th class="mu-hide">Added At</th>
                    <th>Delete User</th>
                </tr>
            </thead>
            <tbody id="users_list">


            </tbody>
            <tfoot>
                <tr>
                    <th>netID</th>
                    <th>Edit Email</th>
                    <th>Role</th>
                    <th class="mu-hide">Last Login At</th>
                    <th class="mu-hide">Added At</th>
                    <th>Delete User</th>
                </tr>
            </tfoot>
        </table>
        <br />

        <div id="pagination"></div>
    </div>

    
    

    <!-- PUT MODAL HERE -->
    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Add a User:</h3>
            <label for="roles">Email:</label>
            <input type="email" name="new_user_email" class="" id="new_user_email" placeholder="Enter Email" />
            <p id="not_ksu_email_error" style="color:red; display:none;">Please enter a KSU faculty/staff email address</p>
            <p id="email_exists_error" style="color:red; display:none;">User already exists</p>
            <label for="roles">Role:</label>
            <select name="roles_select" id="roles_select">
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option name="role_item" id="<?php echo e($role->id); ?>" value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            
            <button type="submit" class="btn search-btn" id="add_user" name="add_user">Submit</button>
        </div>

    </div>






    <div id="edit_user_email_modal" class="modal">
        <!-- EUE = edit user email (so you know its an error msg for this modal) -->
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Edit User's Email:</h3>
            <label for="roles">Email:</label>
            <input type="email" name="edit_user_email" class="" id="edit_user_email" placeholder="" />
            <p id="EUE_not_ksu_email_error" style="color:red; display:none;">Please enter a KSU faculty/staff/student email address</p>
            <p id="EUE_email_exists_error" style="color:red; display:none;">User already exists</p>
            
            
            <button type="submit" class="btn search-btn" id="edit_user_email_submit" name="edit_user_email">Submit</button>
        </div>

    </div>



    <div id="delete_user_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h4>Delete <span id="user_email"></span>?</h4>
            
            <button type="submit" class="btn search-btn" id="delete_user_submit" name="delete_user_email">Delete</button>
        </div>

    </div>


<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-add-users.blade.php ENDPATH**/ ?>