

<!-- <link href="<?php echo e(asset('css/grid.css')); ?>" rel="stylesheet"> -->

<!-- 
Title | Authored By | Created At | State | Edit

1.) Make posts searchable by time between current time and 12am
2.) Make posts searchable by post_state (Needs Review)



 -->


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
             * Edit post_state of post onchange()
             * ===============================================================================
             */
        
            
            $('select[name="post_state_select"]').change(function(){
                var state = $(this).val();
                var id = $(this).prop('id');

                // console.log('state:', state);
                // console.log('id:', id);

                $.ajax({
                    url: '/update-post-state/' + id + '/' + state,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        console.log('response: ', response);
                    }
                });

            });
            
        });

        
    </script>


    <h1>Moderator Moderate Posts</h1>

    <form action="<?php echo e(route('moderator.moderate-posts-submit')); ?>" method="get" enctype="multipart/form-data">
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
                    <?php if(isset($accounts)): ?>
                        <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option name="account_option" id="account_option" value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                    <?php endif; ?>
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

        <!-- Post_state -->
        <div>
            <label for="post_state">Post State:</label>
            <select name="state_select" id="state_select">
                    <!-- <option name="state_option" id="category" value="0" selected>- Post State -</option> -->

                    <option name="state_option" id="all" value="All" selected>All</option>
                    <option name="state_option" id="needs_review" value="Needs Review">Needs Review</option>
                    <option name="state_option" id="publish" value="Publish">Publish</option>
            </select>
        </div><br>
        <button id="submit_btn" type="submit">Apply</button>
    </form>



    <div>
        <?php if(session('post-updated-message')): ?>
            <div><h4 class="success"><?php echo e(session('post-updated-message')); ?></h4></div>

        <?php elseif(session('post-created-message')): ?>
            <div><h4 class="success"><?php echo e(session('post-created-message')); ?></h4></div>
            
        <?php elseif(session('post-deleted-message')): ?>
            <div><h4 class="success"><?php echo e(session('message')); ?></h4></div>
        <?php endif; ?>
    </div>


    <!-- DataTale -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Authored By</th>
                            <th>Updated At</th>
                            <th>State</th>
                            <th>Edit</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Authored By</th>
                            <th>Updated At</th>
                            <th>State</th>
                            <th>Edit</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        <?php if(isset($posts)): ?>
                            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($post->title); ?></td>
                                    <td><?php echo e($post->from_account); ?></td>
                                    <td><?php echo e($post->updated_at->diffForHumans()); ?></td>
                                    <td>
                                        <select id="<?php echo e($post->id); ?>" name="post_state_select">
                                            <?php if($post->post_state == 'Needs Review'): ?>
                                                <option id="Needs Review" value="Needs Review" selected>Needs Review</option>
                                                <option id="Publish" value="Publish">Publish</option>
                                            <?php endif; ?>
                                            <?php if($post->post_state == 'Publish'): ?>
                                                <option id="Needs Review" value="Needs Review">Needs Review</option>
                                                <option id="Publish" value="Publish" selected>Publish</option>
                                            <?php endif; ?>     
                                        </select>
                                    </td>
                                    <td><a href="<?php echo e(route('moderator.edit-post', $post->id)); ?>"><button>Edit Post</button></a></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <?php if(isset($noPosts)): ?>
                            <h2><?php echo e($noPosts); ?></h2>
                        <?php endif; ?>
                    </tbody>

                </table>
                <!-- pagination -->
                <ul class="pagination">
                    <?php if(isset($posts)): ?>
                        <?php echo e($posts->links()); ?>

                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('moderator.moderator-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/moderator/moderator-moderate-posts.blade.php ENDPATH**/ ?>