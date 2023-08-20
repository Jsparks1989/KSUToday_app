<!-- ====================================================================================================== 
 * Admin preview post view   
 
 * URL - APP_URL/post-preview

 * CHILD VIEW of - admin.admin-master      
 
 * What page is doing:
    - when user creates a new post, hit Preview btn
    - allows user to preview how the post will look before saving
    - user can click the back btn on browser to return to create-post

 * Controller 
    - PageController@postPreview() -> AdminController@postPreview()
        > route - /post-preview

 * JS file 
    - app/public/js/root.js
    - app/public/js/toast/global-toast-variables-functions.js

 * CSS file
    - 
 ====================================================================================================== -->







<!-- yield from admin.admin-master -->
<?php $__env->startSection('admin-css-styles'); ?>
    
<?php $__env->stopSection(); ?>

<!-- yield from admin.admin-master -->
<?php $__env->startSection('admin-js-scripts'); ?>
    
<?php $__env->stopSection(); ?>

<!-- yield from component.app-base -->
<?php $__env->startSection('main'); ?>
    <div class="sp-container">
        <h1><?php echo e($inputs['title']); ?></h1>

        
        <p class="sp-posted-by"><span class="right"> Posted By: <span class="bold"><?php echo e($inputs['from_account']); ?></span></span></p>


        <span class="sp-category"><span class="right bold"><?php echo e($inputs['category_name']); ?></span></span>

        <div class="sp-image">
            <img src="<?php echo e(asset('/storage/' . $inputs['image'])); ?>" alt="image for the post">
        </div>

        <div class="sp-full-message">
            <p><?php echo e($inputs['full_message']); ?></p>

            <?php if($inputs['file_attach'] != null && $inputs['file_attach'] != 'Temporary file_attach'): ?>
                <!-- <h3>Attached File:</h3> -->
                
                <p class="bold sp-file-attach">View Attachment</p>
            <?php endif; ?>

        </div>

        
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-preview-post.blade.php ENDPATH**/ ?>