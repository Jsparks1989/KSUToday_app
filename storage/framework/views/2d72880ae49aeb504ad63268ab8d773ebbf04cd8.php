

<?php $__env->startSection('main'); ?>


    <div>
        <div>
            <h2><?php echo e($post->title); ?></h2>
        </div>
        <div>
            <h3>Category:</h3>
            <?php echo e($post->category->name); ?>

        </div>
        <?php if($post->topic_id != '0'): ?>
            <div>
                <h3>Topic:</h3>
                <?php echo e($post->topic->name); ?>  
            </div>
        <?php endif; ?>
        <div>
            <h3>Posted By:</h3>
            <?php echo e($post->user->name); ?>

        </div>
        <div>
            <h3>Full Message:</h3>   
            <?php echo e($post->full_message); ?>

        </div>
        <div>
            <h3>Image:</h3>
            <img width="535px" height="360px" src="<?php echo e(asset('/storage/' . $post->image)); ?>" alt="image for the post">
        </div>
        <?php if($post->file_attach != 'Temporary file_attach'): ?>
            <div>
                <h3>File Attached:</h3>
                <a href="<?php echo e(route('file.get-file', $post->id)); ?>"><?php echo e($file_name); ?></a>
            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/admin/admin-show-post.blade.php ENDPATH**/ ?>