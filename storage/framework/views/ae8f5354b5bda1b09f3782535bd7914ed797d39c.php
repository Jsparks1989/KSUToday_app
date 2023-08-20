




<?php $__env->startSection('main'); ?>
    <div class="sp-container">
        <h1><?php echo e($post->title); ?></h1>

        <p class="sp-created-at"><em><?php echo e(date('m-d-Y',strtotime($post->created_at))); ?></em></p>
        <p class="sp-posted-by"><span class="right"> Posted By: <span class="bold"><?php echo e($post->from_account); ?></span></span></p>


        <span class="sp-category"><span class="right bold"><?php echo e($post->category->name); ?></span></span>

        <div class="sp-image">
            <img src="<?php echo e(asset('/storage/' . $post->image)); ?>" alt="image for the post">
        </div>

        <div class="sp-full-message">
            <p><?php echo e($post->full_message); ?></p>

            <?php if($post->file_attach != null && $post->file_attach != 'Temporary file_attach'): ?>
                <!-- <h3>Attached File:</h3> -->
                <a href="<?php echo e(route('file.get-file', $post->id)); ?>">View Attachment</a>
            <?php endif; ?>
        </div>

        

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.app-base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/digest/digest-post.blade.php ENDPATH**/ ?>