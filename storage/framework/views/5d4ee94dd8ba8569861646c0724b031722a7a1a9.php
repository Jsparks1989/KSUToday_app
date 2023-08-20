<!-- ====================================================================================================== 
 * Admin create post view   
 
 * URL - APP_URL/create-post

 * CHILD VIEW of - admin.admin-master    

 * What page is doing:
    - user creates new post
    - sections with red star are required; when form is sent to controller, form data is checked for validation
    - user can save the post, or preview the post and then save it
    - if the user does not upload an image, a stock image is used depending on the post category
 
 * Controller 
    - PageController@createPost() -> AdminController@createPost()
        > route - /create-post

    - PageController@storePost() -> AdminController@storePost() when user clicks 'save'
        > route - /store-post

    - PageController@postPreview() -> AdminController@postPreview() when user clicks 'preview'
        > route - /post-preview

 * JS file 
    - app/public/js/root.js
    - app/public/js/create-post.js
    - app/public/js/toast/toastr.js
    - app/public/js/toast/toast-messages.js
    - app/public/js/toast/global-toast-variables-functions.js
    

 * CSS file
    - 
 ====================================================================================================== -->





<!-- yield from admin-master.blade.php -->
<?php $__env->startSection('admin-js-scripts'); ?>
    <script src="<?php echo e(asset('js/create-post.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<!-- yield from admin-master.blade.php -->
<?php $__env->startSection('admin-css-styles'); ?>

<?php $__env->stopSection(); ?>

<!-- yield from component.app-base -->
<?php $__env->startSection('main'); ?>


    <h1>Create Post</h1>

    <?php echo $__env->make('components.sessions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    

    <form action="<?php echo e(route('store-post')); ?>" method="POST" id="createPost" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <!-- Post Title -->
        <div class="">
            <div>
                <label for="title">Post Title: <span class="form_required">*</span></label>
                <div>(subject of message)</div>
            </div>
            <input type="text" 
                   name="title" 
                   id="title"
                   class="" 
                   placeholder="Enter Title" 
                   value="<?php echo e(old('title')); ?>"
                   aria-describedby="">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>



        

        <!-- Categories -->
        <div class="">
            <div>
                <label for="category_id">Category: <span class="form_required">*</span></label>
            </div>

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <input type="radio" 
                        name="category_id" 
                        id="<?php echo e($category->id); ?>"
                        value="<?php echo e($category->id); ?>"
                        class="">
                    <label for="category_id"><?php echo e($category->name); ?></label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>




        <!-- Topic Tags -->
        <div class="" id="post_topics" hidden>
            <div>
                <label for="">Topics:</label>
                <div>(optional)</div>
                    <div id="topics_btns">

                    </div>

            </div>
        </div>
        <br>



        <!-- Post From Account -->
        <div class="">
            <div>
                <label for="from_account">Posted By: <span class="form_required">*</span></label>
            </div>
            <select name="from_account" id="from_account">
                <!-- Replace netID with authorized current user's actual netID -->
                <option name="from_account" id="<?php echo e($netID); ?>" value="<?php echo e($netID); ?>"><?php echo e($netID); ?></option>
                <!-- Make a table of alternative accounts to post from & loop through them -->
                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option name="from_account" id="<?php echo e($account->name); ?>" value="<?php echo e($account->name); ?>"><?php echo e($account->name); ?></option>
                <!-- <option value="Coles College">Coles College</option>
                <option value="College of Computing">College of Computing</option> -->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['from_account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>



        <!-- Summary -->
        <div class="">
            <div>
                <label for="summary">Summary: <span class="form_required">*</span></label>
                <div>(brief description that appears in email digest)</div>
            </div>
            <textarea name="summary" id="summary" class="" cols="30" rows="5" maxlength="300"><?php echo e(old('summary')); ?></textarea>
            <div id="count"></div>
            <?php $__errorArgs = ['summary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- Full Message -->
        <div class="">
            <div>
                <label for="full_message">Full Message: <span class="form_required">*</span></label>
                <div>(entire content of message)</div>
            </div>
            <!-- <textarea name="full_message" id="full_message" class="" cols="30" rows="10"></textarea> -->
            <textarea name="full_message" class="" cols="30" rows="10" maxlength="5000"><?php echo e(old('full_message')); ?></textarea>
            <?php $__errorArgs = ['full_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- Image -->
        <!-- <div class=""> -->
            <!-- <div> -->
                <label for="image">Image:</label>
                <!-- <div>(picture related to post, optional, a default image will appear if none uploaded. Note: images are displayed in landscape at 1:1.5 aspect ratio)</div> -->
            <!-- </div> -->
            <input type="file" 
                   name="image" 
                   id="image"
                   class="">
            <!-- Upload requirements should display a modal window describing the requirements for uploading an image -->
            <!-- <div>Upload Requirements</div> -->
            <?php $__errorArgs = ['image'];
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


        <!-- File Attachment -->
        <div class="">
            <div>
                <label for="file_attach">File Attachment:</label>
                <!-- <div>(additional information)</div> -->
            </div>
            <input type="file" 
                   name="file_attach" 
                   id="file_attach"
                   class="">
            <!-- Upload requirements should display a modal window describing the requirements for uploading a file -->
            <!-- <div>Upload Requirements</div> -->
            <?php $__errorArgs = ['file_attach'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- Post State -->
        <!-- Contributors should not have the option to set post_state. It will be automatically set to "Needs Review" -->
        <!-- Only Moderators and Admins have the ability to change change post_state -->
        <!-- <div class="">
            <div>
                <label for="post_state">Post State: *</label>
            </div>
            <input type="radio" 
                   name="post_state" 
                   id="post_state"
                   value="Needs Review"
                   class=""
                   checked>
            <label for="post_state">Needs Review</label><br>

            <input type="radio" 
                   name="post_state"
                   id="post_state"  
                   value="Publish" 
                   class="">
            <label for="post_state">Publish Online</label><br>
        </div> -->
        <br>


        <button type="submit" class="submit_btn">Save</button>
        <button type="submit" formaction="<?php echo e(route('post-preview')); ?>" class="submit_btn">Preview</button>
    </form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-create-post.blade.php ENDPATH**/ ?>