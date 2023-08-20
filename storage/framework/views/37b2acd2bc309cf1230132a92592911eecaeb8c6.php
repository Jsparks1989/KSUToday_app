
<!-- ====================================================================================================== -->
<!-- Home | Users Read Posts view -->
<!-- CHILD VIEW of: user-master.blade.php                                                                   -->

<!-- #header @navbar  includes: 1) Home btn(user-index.blade.php), 2) Read Posts btn(user-read-all-posts.blade.php)-->
<!-- #main includes: Run SQL query for all posts and display them all through loop -->
<!-- #sidebar-right includes: Nothing (logout btn is in user-master)                                        -->

<!-- ====================================================================================================== -->







<?php $__env->startSection('css-styles'); ?>
    <link href="<?php echo e(asset('css/success.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>

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
            * Displaying Topics
            * ===============================================================================
            */

        // When a category is chosen
        $('select[name="categories_select"]').click(function(){
            // Need to empty <select id="topics"> or else topics will stack on each other
            $('select[id="topics"]').find("*").not(".leave_me").remove();
            // Set the id of chosen category to variable
            var catId = Number($('option[name="category_item"]:checked').attr('value'));
            // If catId is not 0...
            if(catId != 0){
                // Display the #topics div of chosen category
                $('#topics').show();
                // Fetch all the topics of chosen category & display them 
                fetchTopics(catId);
            }
        });

        // Define fetchTopics()
        function fetchTopics(id){
            $.ajax({
                url: '/get-topics/' + id,
                type: 'get',
                dataType: 'json',
                success: function(response){
                    let length = 0;
                    // Making sure the div holding the topics is empty
                    $('#topics_btns').empty();

                    if(response['topics'] != null){
                        // setting response data array length to variable
                        length = response['topics'].length;

                        // if the length of the data array is longer than 0...
                        if(length > 0){
                            // loop through data array
                            for(let i = 0; i < length; i++){
                                // set topic attributes to variables
                                let id = response['topics'][i].id;
                                let category_id = response['topics'][i].category_id;
                                let name = response['topics'][i].name;
                                let created_at = response['topics'][i].created_at;
                                let updated_at = response['topics'][i].updated_at;
                                let tr_str = "<option name='topic' id='"+id+"' value='"+id+"'>"+name+"</option>";
                                $('select[id="topics"]').append(tr_str);
                                // <option name="topic" id="topic" value="0" selected>- Topics -</option>
                            }
                        }
                    }
                }
            });
        }




        /**
            * =============================================================================== 
            * Displaying NetID input option
            * ===============================================================================
            */

        // When option <- search by netID -> is chosen
        $('select[name="accounts_select"]').click(function(){
            console.log($(this).val());
            $('#netID_section').show();
            if($(this).val() != 'netID'){
                $('#netID_section').hide();
            }
        });


        /**
            * =============================================================================== 
            * Pagination
            * ===============================================================================
            */
        
    });
    
</script>

    <h1>Admin: Read All Posts page</h1>

    <form action="<?php echo e(route('admin.read-post-submit')); ?>" method="get" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div>
            <!-- Search by Post Title -->
            <div>
                <label for="title">Search by Title:</label>
                <input type="text" name="title"></input>
            </div>
            <div>OR</div>





            <!-- accounts -->
            <div>
                <label for="accounts_select">Accounts:</label>
                <select name="accounts_select" id="accounts_select">
                        <option name="account_option" id="account_option_default" value="0" selected>- Accounts -</option>
                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option name="account_option" id="account_option" value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                        <option name="account_option" id="account_netID" value="netID">- Search By netID -</option>
                </select>
            </div><br>
        



            <!-- netID -->
            <div id="netID_section" hidden>
                <label for="netID">netIDs:</label>
                <input type="text" name="netID"></input>
            </div><br>



            <div>OR</div>




            <div>
                <!-- Categories -->
                <div>
                    <label for="categories">Search by Category:</label>
                    <select name="categories_select" id="categories">
                            <option name="category_item" id="category" value="0" selected>- Categories -</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option name="category_item" id="category" value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Topics -->
                <div id="topics" hidden>
                        <label for="topics">Topics:</label>
                        <select name="topics_select" id="topics">
                            <option class="leave_me" name="topic_item" id="topic" value="0" selected>- Topics -</option>
                        </select>
                </div>                
            </div>
        </div>

        <div>
            <select name="order_by" id="order_by">
                <option name="order_by" value="newest" selected>Newest</option>
                <option name="order_by" value="oldest">Oldest</option>
            </select>
        </div>
        <button id="submit_btn" type="submit">Apply</button>
    </form>

    <div class="list-of-posts" id="allPosts">
        <?php if(isset($posts)): ?>
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="postItem">
                    <hr>
                    <div>
                        <h2><?php echo e($post->title); ?></h2>
                    </div>
                    <div>
                        <h3>Image:</h3>
                        <img width="275px" height="185px" src="<?php echo e(asset('/storage/' . $post->image)); ?>" alt="image for the post">
                    </div>
                    <div>
                        <h3>Date:</h3>
                        <?php echo e($post->updated_at); ?>

                    </div>
                    <div>
                        <h3>Category:</h3>
                        <?php echo e($post->category->name); ?>

                    </div>
                    <div>
                        <h3>Posted by:</h3>
                        <?php echo e($post->from_account); ?>

                    </div>
                    <div>
                        <h3>Summary:</h3>
                        <?php echo e($post->summary); ?>

                        <a href="<?php echo e(route('admin.show-post', $post->id)); ?>">Read More &rarr;</a>
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
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/admin/admin-read-all-posts.blade.php ENDPATH**/ ?>