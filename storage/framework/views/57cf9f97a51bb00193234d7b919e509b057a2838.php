


<?php $__env->startSection('css-styles'); ?>
    <link href="<?php echo e(asset('css/success.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/errors.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/modal_delete.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/modal_edit.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-scripts'); ?>
    <script src="<?php echo e(asset('js/modal_delete.js')); ?>"></script>
    <script src="<?php echo e(asset('js/modal_edit_user.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('main'); ?>


    <script>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            /**
             * =============================================================================== 
             * Displaying edit user modal - DONT NEED IT NOW
             * ===============================================================================
             */


            $('button[name="edit"]').click(function(){
                var userId = Number($(this).attr('value'));
                fetchUser(userId);
            });

            
            // Define fetchUser()
            function fetchUser(id){
                $.ajax({
                    url: '/get-user/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                            if(response['user'] != null){
                                document.getElementById(response['user'].role_id).selected = true;
                            }
                    }
                });
            }


            /**
             * =============================================================================== 
             * Displaying NetID input option
             * ===============================================================================
             */

            // When option <- search by netID -> is chosen
            $('select[name="search_roles_select"]').click(function(){
                // console.log($(this).val());
                $('#netID_section').show();
                if($(this).val() != 'netID'){
                    $('#netID_section').hide();
                }
            });




            /**
             * =============================================================================== 
             * Edit role_id of user onchange
             * ===============================================================================
             */
        
            $('select[name="user_role_select"]').change(function(){
                var role = $(this).val();
                var id = $(this).prop('id');

                $.ajax({
                    url: '/update-user-role/' + id + '/' + role,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        
                    }
                });

            });

        });
    </script>


    <h1>Admin: Add Contributors, Moderators and Admins</h1>
    <p>This is where the admin can add people to the users table as contributors</p>


    <div>
        <?php if(session('user-created-message')): ?>
            <div><h4 class="success"><?php echo e(session('user-created-message')); ?></h4></div>

        <?php elseif(session('user-removed-message')): ?>
            <div><h4 class="success"><?php echo e(session('user-removed-message')); ?></h4></div>

        <?php elseif(session('user-updated-message')): ?>
            <div><h4 class="success"><?php echo e(session('user-updated-message')); ?></h4></div>
        <?php endif; ?>
    </div>


    <form action="<?php echo e(route('admin.store-new-users')); ?>" method="POST" enctype="multipart/form-data">
        <!-- csrf is a directive - laravels way of not allowing others on another server submit data through the form. -->
        <?php echo csrf_field(); ?>

        <!-- User's netID -->
        <div class="">
            <div>
                <label for="netID">User's netID: *</label>
            </div>
            <input type="text" 
                   name="netID" 
                   id="netID"
                   class="" 
                   placeholder="Enter netID">
            <?php $__errorArgs = ['netID'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- Wont need email or password for final version. When user signs in using the Login System, will compare user's netID to the users table -->
        <!-- Only doing email and password here so app will work on local machine -->
        <!-- Final version should only need netID and role_id to link netID to proper role. -->


        <!-- User's email -->
        <div class="">
            <div>
                <label for="netID">User's Email: *</label>
            </div>
            <input type="email" 
                   name="email" 
                   id="email"
                   class="" 
                   placeholder="Enter Email">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>

    

        <!-- User's password -->
        <div class="">
            <div>
                <label for="password">User's Password: *</label>
            </div>
            <input type="password" 
                   name="password" 
                   id="password"
                   class="" 
                   placeholder="Enter Password">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- User's Role -->
        <div>
            <label for="roles">Role:</label>
            <select name="roles_select_new">
                    <!-- <option name="role_item" id="role" value="0" selected>- Categories -</option> -->
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option name="role_item" id="role" value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <br>


        <button type="submit" class="">Add User</button>

    </form>




    <form action="<?php echo e(route('admin.search-users')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <h2>Search for User</h2>
        
        <div>
            <label for="roles">Role:</label>
            <select name="search_roles_select">
                    <option name="role_item" id="role" value="All" selected>- All Roles -</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option name="role_item" id="role" value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <option name="account_option" id="account_netID" value="netID">- Search By netID -</option>
            </select>
        </div><br>
        

        <div id="netID_section" hidden>
            <label for="netID">Search by netID:</label>
            <input type="text" name="netID"></input>
        </div><br>
        

        <button type="submit" name="search_contributors">Search</button>
    </form>




    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>netID</th>
                            <th>Role</th>
                            <th>Added At</th>
                            
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>netID</th>
                            <th>Role</th>
                            <th>Added At</th>
                            
                        </tr>
                    </tfoot>

                    <tbody>
                        <?php if(isset($users)): ?>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($user->name); ?></td>
                                    
                                    <td>
                                        <select id="<?php echo e($user->id); ?>" name="user_role_select">
                                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($user->role_id == $role->id): ?>
                                                        <option id="<?php echo e($role->name); ?>" value="<?php echo e($role->id); ?>" selected><?php echo e($role->name); ?></option>
                                                    <?php else: ?> 
                                                        <option id="<?php echo e($role->name); ?>" value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>









                                           
                                                
                                        </select>
                                    </td>
                                    <td><?php echo e($user->created_at->diffForHumans()); ?></td>
                                    
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <?php if(isset($noUsers)): ?>
                            <h2><?php echo e($noUsers); ?></h2>
                        <?php endif; ?>
                    </tbody>

                </table>
                <!-- pagination -->
                <ul class="pagination">
                    <?php if(isset($users)): ?>
                        <?php echo e($users->links()); ?>

                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>


    <!-- The Modal Delete -->
    <div id="modal_delete" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="deleteClose">&times;</span>
            <p>Some text in the Modal..</p>
            <form action="<?php echo e(route('admin.remove-users')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="text" id="modal_delete_user_id" name="user_id" style="display:none;">
                <button type="submit">Delete</button>
            </form>
            
            <button class="deleteClose" id="modal_cancel_button">Cancel</button>
        </div>
    </div>



    <!-- The Modal Edit -->
    <div id="modal_edit" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="editClose">&times;</span>
            <p>Edit User Role</p>
            <form action="<?php echo e(route('admin.update-users')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="text" id="modal_edit_user_id" name="user_id" style="display:none;">
                <div>
                    <label for="roles">Role:</label>
                    <select name="roles_select" >
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option name="role_item" id="<?php echo e($role->id); ?>" value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit">Update</button>
            </form>
            
            <button class="editClose" id="modal_cancel_button">Cancel</button>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/admin/admin-add-users.blade.php ENDPATH**/ ?>