


<?php $__env->startSection('css-styles'); ?>
    <link href="<?php echo e(asset('css/errors.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/success.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/ksu_css/default.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('main'); ?>


    <script>
        $(document).ready(function(){

            //-- Script that displays the Topics section when a Category is chosen && runs fetchTopics()
            $('input[name="category_id"]').click(function(){
                // Display topics 
                $('#post_topics').show();
                // Set chosen category->id to var
                var catId = Number($('input[name="category_id"]:checked').attr('id'));
                console.log('catId: ', catId);
                // run function with chosen category->id
                fetchTopics(catId);
            });


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                                console.log('topics response not null:', response);
                                // setting response data array length to variable
                                length = response['topics'].length;

                                // if the length of the data array is longer than 0...
                                if(length > 0){
                                    // loop through data array
                                    for(let i = 0; i < length; i++){
                                        // console.log(response['data'][i]);

                                        // set topic attributes to variables
                                        let id = response['topics'][i].id;
                                        console.log('id: ', id);
                                        let category_id = response['topics'][i].category_id;
                                        let name = response['topics'][i].name;
                                        let created_at = response['topics'][i].created_at;
                                        let updated_at = response['topics'][i].updated_at;
                                        let tr_str = "<div><input type='radio' name='topic_id' id='"+id+"' value='"+id+"'>"+
                                        "<label for='post_topic'>"+name+"</label></div>";
                                        $('#topics_btns').append(tr_str);
                                    
                                    }
                                }
                            }
                    }
                });
            }
        });
    </script>





    <h1>Administrator Create Post</h1>

    <div>
        <?php if(session('post-updated-message')): ?>
            <div><h4 class="success"><?php echo e(session('post-updated-message')); ?></h4></div>

        <?php elseif(session('post-created-message')): ?>
            <div><h4 class="success"><?php echo e(session('post-created-message')); ?></h4></div>
            
        <?php elseif(session('post-deleted-message')): ?>
            <div><h4 class="success"><?php echo e(session('message')); ?></h4></div>
        <?php endif; ?>
    </div>

    

    <form action="<?php echo e(route('admin.store-post')); ?>" method="POST" id="createPost" enctype="multipart/form-data">
        <!-- csrf is a directive - laravels way of not allowing others on another server submit data through the form. -->
        <?php echo csrf_field(); ?>

        <!-- Post Title -->
        <div class="">
            <div>
                <label for="title">Post Title: <span class="form_required">*</span></label>
                <div>(subject of message)</div>
            </div>
            <input type="text" 
                   name="title" 
                   id="title"
                   class="" 
                   placeholder="Enter Title" 
                   aria-describedby="">
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>



        

        <!-- Categories -->
        <div class="">
            <div>
                <label for="category_id">Category: <span class="form_required">*</span></label>
            </div>

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
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
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>




        <!-- Topic Tags -->
        <div class="" id="post_topics" hidden>
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
                <label for="from_account">Post From Account: <span class="form_required">*</span></label>
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
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>



        <!-- Summary -->
        <div class="">
            <div>
                <label for="summary">Summary: <span class="form_required">*</span></label>
                <div>(brief description that appears in email digest)</div>
            </div>
            <textarea name="summary" id="summary" class="" cols="30" rows="5"></textarea>
            <?php $__errorArgs = ['summary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- Full Message -->
        <div class="">
            <div>
                <label for="full_message">Full Message: <span class="form_required">*</span></label>
                <div>(entire content of message)</div>
            </div>
            <!-- <textarea name="full_message" id="full_message" class="" cols="30" rows="10"></textarea> -->
            <textarea name="full_message" class="" cols="30" rows="10"></textarea>
            <?php $__errorArgs = ['full_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- Image -->
        <!-- <div class=""> -->
            <!-- <div> -->
                <label for="image">Image:</label>
                <!-- <div>(picture related to post, optional, a default image will appear if none uploaded. Note: images are displayed in landscape at 1:1.5 aspect ratio)</div> -->
            <!-- </div> -->
            <input type="file" 
                   name="image" 
                   id="image"
                   class="">
            <!-- Upload requirements should display a modal window describing the requirements for uploading an image -->
            <!-- <div>Upload Requirements</div> -->
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <!-- </div> -->
        <br>


        <!-- File Attachment -->
        <div class="">
            <div>
                <label for="file_attach">File Attachment:</label>
                <!-- <div>(additional information)</div> -->
            </div>
            <input type="file" 
                   name="file_attach" 
                   id="file_attach"
                   class="">
            <!-- Upload requirements should display a modal window describing the requirements for uploading a file -->
            <!-- <div>Upload Requirements</div> -->
            <?php $__errorArgs = ['file_attach'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <h4 class="error"><?php echo e($message); ?></h4>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <br>


        <!-- Post State -->
        <!-- Contributors should not have the option to set post_state. It will be automatically set to "Needs Review" -->
        <!-- Only Moderators and Admins have the ability to change change post_state -->
        <!-- <div class="">
            <div>
                <label for="post_state">Post State: *</label>
            </div>
            <input type="radio" 
                   name="post_state" 
                   id="post_state"
                   value="Needs Review"
                   class=""
                   checked>
            <label for="post_state">Needs Review</label><br>

            <input type="radio" 
                   name="post_state"
                   id="post_state"  
                   value="Publish" 
                   class="">
            <label for="post_state">Publish Online</label><br>
        </div> -->
        <br>


        <button type="submit" class="submit_btn">Save</button>
        <button type="submit" formaction="<?php echo e(route('contributor.post-preview')); ?>" class="submit_btn">Preview</button>
    </form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/admin/admin-create-post.blade.php ENDPATH**/ ?>