




<?php $__env->startSection('main'); ?>
    <h1>Moderator Read My Posts</h1>
    <?php if(isset($posts)): ?>
        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
            <hr>
                <div>
                    <h2><?php echo e($post->title); ?></h2>
                </div>
                <div>
                    <h3>Category:</h3>
                    <?php echo e($post->category->name); ?>

                </div>
                <div>
                    <h3>Posted By:</h3>
                    <?php echo e($post->user->name); ?>

                </div>
                <div>
                <h3>Summary:</h3>
                    <?php echo e($post->summary); ?>

                    <a href="<?php echo e(route('moderator.show-post', $post->id)); ?>">Read More &rarr;</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
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
<?php echo $__env->make('moderator.moderator-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/moderator/moderator-read-my-posts.blade.php ENDPATH**/ ?>