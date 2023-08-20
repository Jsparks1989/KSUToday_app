


<?php $__env->startSection('css-styles'); ?>
    <!-- <link href="<?php echo e(asset('css/success.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/errors.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/modal_delete.css')); ?>" rel="stylesheet"> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-scripts'); ?>
    <!-- <script src="<?php echo e(asset('js/modal_delete.js')); ?>"></script> -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('main'); ?>


<script>
    $(document).ready(function(){


        /**
         * =============================================================================== 
         * Displaying NetID input option
         * ===============================================================================
         */

        
        // When option <- search by netID -> is chosen
        $('select[name="contributors_select"]').click(function(){
            console.log($(this).val());
            $('#netID_section').show();
            if($(this).val() != 'netID'){
                $('#netID_section').hide();
            }
        }); 

    });
</script>


    <h1>Moderate Contributors</h1>

    <div>
        <?php if(session('contributor-created-message')): ?>
            <div><h4 class="success"><?php echo e(session('contributor-created-message')); ?></h4></div>

        <?php elseif(session('contributor-removed-message')): ?>
            <div><h4 class="success"><?php echo e(session('contributor-removed-message')); ?></h4></div>

        <?php endif; ?>
    </div>


    <form action="<?php echo e(route('moderator.store-new-contributors')); ?>" method="POST" enctype="multipart/form-data">
        <!-- csrf is a directive - laravels way of not allowing others on another server submit data through the form. -->
        <?php echo csrf_field(); ?>
        <h3>Add a Contributor</h3>
        <!-- Contributor's netID -->
        <!-- <div class=""> -->
            <!-- <div> -->
                <label for="netID">Contributor's netID: <span class="form_required">*</span></label>
            <!-- </div> -->
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
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <!-- </div> -->
        <br>


        <!-- Wont need email or password for final version. When user signs in using the Login System, will compare user's netID to the users table -->
        <!-- Only doing email and password here so app will work on local machine -->
        <!-- Final version should only need netID and role_id to link netID to proper role. -->


        <!-- Contributor's email -->
        <!-- <div class=""> -->
            <!-- <div> -->
                <label for="netID">Contributor's Email: *</label>
            <!-- </div> -->
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
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <!-- </div> -->
        <br>

    

        <!-- Contributor's password -->
        <div class="">
            <div>
                <label for="password">Contributor's Password: *</label>
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

        <button type="submit" class="btn search-btn" name="add_contributors">Add Contributor</button>

    </form>



    <form action="<?php echo e(route('moderator.search-contributors')); ?>" method="POST" enctype="multipart/form-data">
        <!-- csrf is a directive - laravels way of not allowing others on another server submit data through the form. -->
        <?php echo csrf_field(); ?>
        <h3>Search for a Contributor</h3>
        
        <div>
            <label for="contributors_select">Search:</label>
            <select name="contributors_select" id="contributors_select">
                    <option name="contributors_option" value="All" selected>- All Contributors -</option>  
                    <option name="contributors_option" value="netID">- By netID -</option>
            </select>
        </div><br>
        

        <div id="netID_section" hidden>
            <label for="netID">netIDs:</label>
            <input type="text" name="netID"></input>
        </div><br>
        

        <button type="submit" class="btn search-btn" name="search_contributors">Search</button>
    </form>

    <table class="table">

        <thead>
            <tr>
                <th>netID</th>
                <th>Added At</th>
                <!-- <th>Edit</th> -->
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th>netID</th>
                <th>Added At</th>
                <!-- <th>Edit</th> -->
            </tr>
        </tfoot>

        <tbody>
            <?php if(isset($contributors)): ?>
                <?php $__currentLoopData = $contributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($contributor->name); ?></td>
                        <td><?php echo e($contributor->created_at->diffForHumans()); ?></td>
                        
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if(isset($noContributors)): ?>
                <h2><?php echo e($noContributors); ?></h2>
            <?php endif; ?>
        </tbody>
    </table>
 

    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('moderator.moderator-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/moderator/moderator-add-contributors.blade.php ENDPATH**/ ?>