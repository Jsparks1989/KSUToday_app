<!-- ====================================================================================================== 
 * Moderator edit post preview view   
 
 * URL - APP_URL/edit-post/{post}/post-preview

 * CHILD VIEW of - moderator.moderator-master  
    - moderator-edit-posts ->[click 'Preview']-> moderator-edit-post-preview
 
 
 * What page is doing:
    - user can see how the post will look with the edits before saving it
    - user can click browser back btn to go back and edit more or save

 * Controller 
    - PageController@editPostPreview() -> ModeratorController@editPostPreview()
        > route - /edit-post/{post}/post-preview
    - PageController@storePreviewPost() -> ModeratorController@storePreviewPost() when save btn is clicked
        > route - /store-preview-post

 * JS file 
    - app/public/js/root.js

 * CSS file
    - 
 ====================================================================================================== -->






<!-- yield from component.app-base -->
<?php $__env->startSection('main'); ?>
    <div class="sp-container">
        <h1><?php echo e($inputs['title']); ?></h1>

        
        <!-- No Created At <p> since its only a preview of a post. -->
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






<?php echo $__env->make('moderator.moderator-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/moderator/moderator-edit-post-preview.blade.php ENDPATH**/ ?>