<!-- ====================================================================================================== 
 * Admin edit post preview view   
 
 * URL - APP_URL/edit-post/{post}/post-preview

 * CHILD VIEW of - moderator.moderator-master  
    - admin-edit-posts ->[click 'Preview']-> admin-edit-post-preview
 
 
 * What page is doing:
    - user can see how the post will look with the edits before saving it
    - user can click browser back btn to go back and edit more or save

 * Controller 
    - PageController@editPostPreview() -> AdminController@editPostPreview()
        > route - /edit-post/{post}/post-preview

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
                
                <p class="bold">View Attachment</p>
            <?php endif; ?>
        </div>

        




        



        
    </div>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-edit-post-preview.blade.php ENDPATH**/ ?>