




<?php $__env->startSection('main'); ?>
    <h1>Read My Posts</h1>

    <ul class="read-post-list">
        <?php if(isset($posts)): ?>
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="li-wrapper">
                    <div class="post-list-img">
                        <img  src="<?php echo e(asset('/storage/' . $post->image)); ?>" alt="image for the post">
                    </div>
                    <div class="post-list-content">
                        <h2><a href="<?php echo e(route('contributor.show-post', $post->id)); ?>"><?php echo e($post->title); ?></a></h2>

                        <!-- <div class="li-wrapper"> -->
                            <div class="post-list-created-at"><p><em><?php echo e($post->created_at); ?></em></p></div>
                            <div class="post-list-posted-by"><p class="right">Posted By: <span class="bold"><?php echo e($post->from_account); ?></span></p></div>
                        <!-- </div> -->

                        <p class="post-list-summary"><?php echo e($post->summary); ?></p>

                        <p class="post-list-category">Category: <span class="bold"><?php echo e($post->category->name); ?></span></p>

                        <p class="post-list-read-more"><a href="<?php echo e(route('contributor.show-post', $post->id)); ?>">Read More &rarr;</a></p>

                    </div>
                    
                </li> 
                <hr>
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
<?php echo $__env->make('contributor.contributor-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/contributor/contributor-read-my-posts.blade.php ENDPATH**/ ?>