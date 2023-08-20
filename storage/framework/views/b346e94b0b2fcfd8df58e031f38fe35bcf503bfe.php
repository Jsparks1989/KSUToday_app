

<?php $__env->startSection('css-styles'); ?>
    <!-- <link href="<?php echo e(asset('css/ksu_css/default.css')); ?>" rel="stylesheet"> -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('main'); ?>
    <h1>Read My Posts</h1>

    <ul style="list-style-type: none;">
        <?php if(isset($posts)): ?>
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <div class="post-list-img">
                        <img width="275px" height="185px" src="<?php echo e(asset('/storage/' . $post->image)); ?>" alt="image for the post">
                    </div>

                    <div class="post-list-content">
                        <h2><a href="<?php echo e(route('home.show-post', $post->id)); ?>"><?php echo e($post->title); ?></a></h2>

                        <p><em><?php echo e($post->created_at); ?></em></p>
                        <p>Posted By: <?php echo e($post->from_account); ?></p>


                        <p><?php echo e($post->summary); ?></p>

                        <p><?php echo e($post->category->name); ?></p>

                        <p><a href="<?php echo e(route('home.show-post', $post->id)); ?>">Read More &rarr;</a></p>

                    </div>
                    <hr>
                </li> 
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>

    <?php if(isset($noPosts)): ?>
        <h2><?php echo e($noPosts); ?></h2>
    <?php endif; ?>

    <!-- pagination -->
    <ul class="pagination">
        <?php if(isset($posts)): ?>
            <?php echo e($posts->links()); ?>

        <?php endif; ?>
    </ul>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/admin/admin-read-my-posts.blade.php ENDPATH**/ ?>