


<?php $__env->startSection('css-styles'); ?>
    <link href="<?php echo e(asset('css/errors.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('main'); ?>
    <script>

        $(document).ready(function(){

            /**
             * =============================================================================== 
             * Checking the category, post_state and from_account when page loads
             * ===============================================================================
             */

            window.onload = onPageLoad();
            function onPageLoad(){
                document.getElementById('<?php echo e($post->category_id); ?>').checked = true;
                // document.getElementById('<?php echo e($post->post_state); ?>').checked = true;
                // document.getElementById('<?php echo e($post->from_account); ?>').selected = true;
            }
            


            /**
             * =============================================================================== 
             * Displaying and fetching the topics
             * ===============================================================================
             */

            //-- Script that displays the Topics section when a Category is clicked
            $('input[name="category_id"]').click(function(){
                let catId = Number($('input[name="category_id"]:checked').attr('id'));
                fetchTopics(catId);
            });


            //-- Script that displays the Topics section when a Category has the 'checked' attribute
            if($('input[name="category_id"]:checked')){
                let catId = Number($('input[name="category_id"]:checked').attr('id'));
                fetchTopics(catId);
            }


            /**
             * =============================================================================== 
             * Ajax setup
             * ===============================================================================
             */

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            /**
             * =============================================================================== 
             * Define fetchTopics()
             * ===============================================================================
             */

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
                                // console.log('topics response not null:', response);
                                // setting response data array length to variable
                                length = response['topics'].length;

                                // if the length of the data array is longer than 0...
                                if(length > 0){
                                    // setting the $post->topic_id to variable
                                    let post_topic_id = '<?php echo e($post->topic_id); ?>';
                                    // loop through data array
                                    for(let i = 0; i < length; i++){
                                        // set topic attributes to variables
                                        let id = response['topics'][i].id;
                                        let category_id = response['topics'][i].category_id;
                                        let name = response['topics'][i].name;
                                        let created_at = response['topics'][i].created_at;
                                        let updated_at = response['topics'][i].updated_at;

                                        if(id == post_topic_id){
                                            let tr_str = "<div><input type='radio' name='topic_id' id='"+id+"' value='"+id+"' checked>"+
                                            "<label for='post_topic'>"+name+"</label></div>";
                                            $('#topics_btns').append(tr_str);
                                        } else {
                                            let tr_str = "<div><input type='radio' name='topic_id' id='"+id+"' value='"+id+"'>"+
                                            "<label for='post_topic'>"+name+"</label></div>";
                                            $('#topics_btns').append(tr_str);
                                        }
                                    }
                                }
                            }
                    }
                });
            }

        });
    </script>


    <!-- ===============================================================================================
        Need to figure out where to display flash sessions for when a post is created, updated, deleted
    =============================================================================================== -->


    <h1>Moderator: Edit Post</h1>

    <form action="<?php echo e(route('moderator.update-post', $post->id)); ?>" method="POST" id="editPost" enctype="multipart/form-data">
        <!-- csrf is a directive - laravels way of not allowing others on another server submit data through the form. -->
        <?php echo csrf_field(); ?>

        <!-- Post Title -->
        <div class="">
            <div>
                <label for="title">Post Title: *</label>
                <div>(subject of message)</div>
            </div>
            <input type="text" 
                   name="title" 
                   id="title"
                   class="" 
                   placeholder=""
                   value="<?php echo e($post->title); ?>" 
                   aria-describedby="">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>



        

        <!-- Categories -->
        <div class="">
            <div>
                <label for="category_id">Category: *</label>
                <div>(section of email digest that message appears)</div>
            </div>

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="categories">
                    <input type="radio" 
                        name="category_id" 
                        id="<?php echo e($category->id); ?>"
                        value="<?php echo e($category->id); ?>"
                        class="">
                    <label for="category_id"><?php echo e($category->name); ?></label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>




        <!-- Topic Tags -->
        <div class="topics" id="post_topics">
            <div>
                <label for="">Topics:</label>
                <div>(optional)</div>
                    <div id="topics_btns">

                    </div>

            </div>
        </div>
        <br>




        <!-- Post From Account -->
        <div class="">
            <div>
                <label for="from_account">Post From Account: *</label>
            </div>
            <select name="from_account" id="from_account">
                <!-- Replace netID with authorized current user's actual netID -->
                <option name="from_account" id="<?php echo e($netID); ?>" value="<?php echo e($netID); ?>"><?php echo e($netID); ?></option>
                <!-- Make a table of alternative accounts to post from & loop through them -->
                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option name="from_account" id="<?php echo e($account->name); ?>" value="<?php echo e($account->name); ?>"><?php echo e($account->name); ?></option>
                <!-- <option value="Coles College">Coles College</option>
                <option value="College of Computing">College of Computing</option> -->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['from_account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>



        <!-- Summary -->
        <div class="">
            <div>
                <label for="summary">Summary: *</label>
                <div>(brief description that appears in email digest)</div>
            </div>
            <textarea name="summary" id="summary" class="" cols="30" rows="5"><?php echo e($post->summary); ?></textarea>
            <?php $__errorArgs = ['summary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- Full Message -->
        <div class="">
            <div>
                <label for="full_message">Full Message: *</label>
                <div>(entire content of message)</div>
            </div>
            <textarea name="full_message" id="full_message" class="" cols="30" rows="10"><?php echo e($post->full_message); ?></textarea>
            <?php $__errorArgs = ['full_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- Image -->
        <div class="">
            <div>
                <label for="image">Image:</label>
                <div>(picture related to post, optional, a default image will appear if none uploaded. Note: images are displayed in landscape at 1:1.5 aspect ratio)</div>
            </div>
            <div><img height="150px" width="150px" src="<?php echo e(asset('/storage/' . $post->image)); ?>" alt="image for the post"></div>
            <input type="file" 
                   name="image" 
                   id="image"
                   class="">
            <!-- Add a way to remove the image and replace it -->
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>

        <!-- File Attachment -->
        <div class="">
            <div>
                <label for="file_attach">File Attachment:</label>
            </div>
            <?php if($post->file_attach != null && $post->file_attach != 'Temporary file_attach'): ?>
                <div>  
                    <a href="<?php echo e(route('file.get-file', $post->id)); ?>"><?php echo e($file_name); ?></a>
                </div>
            <?php endif; ?>
            <input type="file" 
                   name="file_attach" 
                   id="file_attach"
                   class="">

            <?php $__errorArgs = ['file_attach'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div><h4 class="error"><?php echo e($message); ?></h4></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <br>


        <button type="submit" class="">Update</button>
        <button type="submit" formaction="<?php echo e(route('moderator.edit-post-preview', $post->id)); ?>" class="">Preview</button>
        
    </form>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('moderator.moderator-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\ksut\resources\views/moderator/moderator-edit-posts.blade.php ENDPATH**/ ?>