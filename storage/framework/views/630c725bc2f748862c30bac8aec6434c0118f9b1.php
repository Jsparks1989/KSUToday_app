
<script>
        $(document).ready(function(){


            // Setting up ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            /**
             * =============================================================================== 
             * Ajax Live Search Below This Line
             * ===============================================================================
             */

            function live_search_read_posts(query = '') {
                $.ajax({
                    url: '/live-search-read-posts',
                    type: 'get',
                    data: {query:query},
                    dataType: 'json',
                    success: function(data) {
                        $('.read-post-list').html(data.table_data);
                        $('#total_records').text(data.total_data);
                        console.log('posts:', data.posts);
                    }
                });
            }
            // live_search_read_posts();




            // Gather the inputs.search_posts
            $(document).on('keyup', '.search_posts', function(){
                let query = {
                    'title': '',
                    'from_account': '',
                    'category' : ''
                };

                query['title'] = $("#title_search").val();
                query['from_account'] = $("#posted_by_search").val();
                query['category'] = $('#categories').val();

                live_search_read_posts(query);
                // console.log('query: ', query);
            });



            $('#categories').change(function() {
                let query = {
                    'title': '',
                    'from_account': '',
                    'category' : ''
                };

                query['title'] = $("#title_search").val();
                query['from_account'] = $("#posted_by_search").val();
                query['category'] = $('#categories').val();

                live_search_read_posts(query);
                console.log('category: ', query);
            });


        });
        
    </script>




        <ul class="read-post-list">
            <?php if(isset($posts)): ?>
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="li-wrapper">
                        <div class="post-list-img">
                            <img  src="<?php echo e(asset('/storage/' . $post->image)); ?>" alt="image for the post">
                        </div>
                        <div class="post-list-content">
                            <h2><a href="<?php echo e(route('show-post', $post->id)); ?>"><?php echo e($post->title); ?></a></h2>

                            <!-- <div class="li-wrapper"> -->
                                <div class="post-list-created-at"><p><em><?php echo e($post->created_at); ?></em></p></div>
                                <div class="post-list-posted-by"><p class="right">Posted By: <span class="bold"><?php echo e($post->from_account); ?></span></p></div>
                            <!-- </div> -->

                            <p class="post-list-summary"><?php echo e(Str::limit($post->summary, 100)); ?></p>

                            <p class="post-list-category">Category: <span class="bold"><?php echo e($post->category->name); ?></span></p>

                            <p class="post-list-read-more"><a href="<?php echo e(route('show-post', $post->id)); ?>">Read More &rarr;</a></p>

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
        <?php echo $posts->links(); ?>

<?php /**PATH /var/www/ksutodaytest/resources/views/components/display-posts.blade.php ENDPATH**/ ?>