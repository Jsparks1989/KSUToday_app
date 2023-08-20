

<?php $__env->startSection('css-styles'); ?>
    <link href="<?php echo e(asset('css/ksu_css/default.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>


<div class="sp-container">
    <h1><?php echo e($post->title); ?></h1>

    <p class="sp-created-at"><em><?php echo e($post->created_at); ?></em></p>
    <p class="sp-posted-by"><span class="right"> Posted By: <span class="bold"><?php echo e($post->from_account); ?></span></span></p>


    <span class="sp-category"><span class="right bold"><?php echo e($post->category->name); ?></span></span>



    <div class="sp-full-message"><p><?php echo e($post->full_message); ?></p></div>
    <div class="sp-image"><img width="535px" height="360px" src="<?php echo e(asset('/storage/' . $post->image)); ?>" alt="image for the post"></div>

    <?php if($post->file_attach != null && $post->file_attach != 'Temporary file_attach'): ?>
            <!-- <h3>Attached File:</h3> -->
            <a href="<?php echo e(route('file.get-file', $post->id)); ?>"><?php echo e($file_name); ?></a>
        <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/admin/admin-show-post.blade.php ENDPATH**/ ?>