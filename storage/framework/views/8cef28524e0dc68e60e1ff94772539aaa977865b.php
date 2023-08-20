<!-- ====================================================================================================== 
 * Contributor create post view   
 
 * URL - APP_URL/create-post

 * CHILD VIEW of - contributor.contributor-master    

 * What page is doing:
    - user creates new post
    - sections with red star are required; when form is sent to controller, form data is checked for validation
    - user can save the post, or preview the post and then save it
    - if the user does not upload an image, a stock image is used depending on the post category
 
 * Controller 
    - PageController@createPost() -> ContributorController@createPost()
        > route - /create-post
    - PageController@storePost() -> ContributorController@storePost() when form is submitted
        > route - /store-post

 * JS file 
    - app/public/js/root.js
    - app/public/js/create-post.js
    - app/public/js/toastr.js
    - app/public/js/toast-messages.js

 * CSS file
    - 
 ====================================================================================================== -->



<!-- yield from contributor-master.blade.php -->
<?php $__env->startSection('contributor-js-scripts'); ?>
    <script src="<?php echo e(asset('js/create-post.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<!-- yield from contributor-master.blade.php -->
<?php $__env->startSection('contributor-css-styles'); ?>

<?php $__env->stopSection(); ?>

<!-- yield from component.app-base -->
<?php $__env->startSection('main'); ?>


    <!-- 
        * TinyMCE: WYSIWYG Editor
        * Documentation: https://www.tiny.cloud/docs/
        * Decided to not use
        * To use, just uncomment script tags below 
    -->
    <!-- 
        <script src="https://cdn.tiny.cloud/1/1v7knrx8m7z8k6gu5cozatz30kuypsr8ve5rq3853n67wawx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src='https://cdn.tiny.cloud/1/1v7knrx8m7z8k6gu5cozatz30kuypsr8ve5rq3853n67wawx/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#full_message'
            });
        </script> 
    -->


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
                        <?php
                        // Input::old('category_id') == $category->id ? "checked": "";
                        ?>
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

                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option name="from_account" id="<?php echo e($account->name); ?>" value="<?php echo e($account->name); ?>"><?php echo e($account->name); ?></option>
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
            <textarea name="full_message" class="" cols="30" rows="10"><?php echo e(old('full_message')); ?></textarea>
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
        <div class="">
            <label for="image">Image:</label>
            <!-- <div>(picture related to post, optional, a default image will appear if none uploaded. Note: images are displayed in landscape at 1:1.5 aspect ratio)</div> -->
            <input type="file" 
                   name="image" 
                   id="image"
                   class="">
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
        </div>
        <br>


        <!-- File Attachment -->
        <div class="">
            <label for="file_attach">File Attachment:</label>
            <input type="file" 
                   name="file_attach" 
                   id="file_attach"
                   class="">
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

        <!-- User cannot set post_state for post -->
        
        <br>


        <button type="submit" class="submit_btn">Save</button>
        <button type="submit" formaction="<?php echo e(route('post-preview')); ?>" class="submit_btn">Preview</button>
    </form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('contributor.contributor-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/contributor/contributor-create-post.blade.php ENDPATH**/ ?>