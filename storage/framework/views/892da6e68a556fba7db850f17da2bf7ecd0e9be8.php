<!-- ====================================================================================================== 
 * Contributor posts status view   
 
 * URL - APP_URL/post-preview

 * CHILD VIEW of - contributor.contributor-master      
 
 * What page is doing:
    - when user creates a new post, hit Preview btn
    - allows user to preview how the post will look before submitting
    - user can click save btn to save post, or the back btn on browser to return to APP_URL/create-post

 * Controller 
    - PageController@postPreview() -> ContributorController@postPreview()
        > route - /post-preview
    - PageController@storePreviewPost() -> ContributorController@storePreviewPost() when save btn is clicked
        > route - /store-preview-post

 * JS file 
    - 

 * CSS file
    - 
 ====================================================================================================== -->








<!-- yield from component.app-base -->
<?php $__env->startSection('main'); ?>

    <div class="sp-container">
        <h1><?php echo e($inputs['title']); ?></h1>

        
        <p class="sp-posted-by"><span class="right"> Posted By: <span class="bold"><?php echo e($inputs['from_account']); ?></span></span></p>


        <span class="sp-category"><span class="right bold"><?php echo e($inputs['category_name']); ?></span></span>



        <div class="sp-full-message"><p><?php echo e($inputs['full_message']); ?></p></div>
        <div class="sp-image"><img width="535px" height="360px" src="<?php echo e(asset('/storage/' . $inputs['image'])); ?>" alt="image for the post"></div>
        <!-- <div class="sp-image"><img width="535px" height="360px" src="<?php echo e($inputs['image']); ?>" alt="image for the post"></div> -->




        <?php if($inputs['file_attach'] != null && $inputs['file_attach'] != 'Temporary file_attach'): ?>
            <!-- <h3>Attached File:</h3> -->
            
            <p class="bold sp-file-attach">View Attachment</p>
        <?php endif; ?>



        <a href="<?php echo e(route('store-preview-post' )); ?>"><button class="submit_btn">Save</button></a>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('contributor.contributor-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/contributor/contributor-preview-post.blade.php ENDPATH**/ ?>