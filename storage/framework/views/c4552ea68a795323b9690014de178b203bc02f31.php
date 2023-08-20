




<?php $__env->startSection('main'); ?>
    

<div>
        <div>
            <h2><?php echo e($inputs['title']); ?></h2>
        </div>
        <div>
            <h3>Category:</h3>
            <?php echo e($inputs['category_name']); ?>

        </div>
        <?php if($inputs['topic_id']!= 'none'): ?>
            <div>
                <h3>Topic:</h3>
                <?php echo e($inputs['topic_name']); ?>  
            </div>
        <?php endif; ?>
        <div>
            <h3>Posted by:</h3>
            <?php echo e($inputs['from_account']); ?>

        </div>
        <div>
            <h3>Full Message:</h3>
            <?php echo e($inputs['full_message']); ?>

        </div>
        <div>
            <h3>Image:</h3>
            <img width="535px" height="360px" src="<?php echo e(asset('/storage/' . $inputs['image'])); ?>" alt="image for the post">
        </div>
        <?php if($inputs['file_attach'] != null && $inputs['file_attach'] != 'Temporary file_attach'): ?>
            <div>  
                <h3>Attached File:</h3>
                <?php echo e($inputs['file_name']); ?>

            </div>
        <?php endif; ?>

        <a href="<?php echo e(route('admin.store-preview-post' )); ?>"><button>Save</button></a>
        

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/admin/admin-preview-post.blade.php ENDPATH**/ ?>