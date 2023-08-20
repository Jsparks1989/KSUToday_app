<!-- ====================================================================================================== 
 * Moderator edit post view   
 
 * URL - APP_URL/edit-post/{post}

 * CHILD VIEW of - moderator.moderator-master  
    - moderator-moderate-posts ->[click 'edit post']-> moderator-edit-posts
 
 
 * What page is doing:
    - post data is loaded into form inputs and user can edit the post
    - user can 'Update' or 'Preview' the post 

 * Controller 
    - PageController@editPost() -> ModeratorController@editPost()
        > route - /edit-post/{post}

    - PageController@editPostPreview() -> ModeratorController@editPostPreview() when user clicks 'Preview' btn
        > route - /edit-post/{post}/post-preview

    - PageController@updatePost() -> ModeratorController@updatePost() when user clicks 'Update' btn
        > route - /update-post/{post}

 * JS file 
    - app/public/js/root.js

 * CSS file
    - 
 ====================================================================================================== -->



@extends('moderator.moderator-master')


<!-- yield from moderator-master.blade.php -->
@section('moderator-js-scripts')
    <!-- <script src="{{asset('js/edit-posts.js')}}"></script> -->
    <!-- <script src="{{asset('js/mod-moderate-posts.js')}}"></script> -->
@endsection


<!-- yield from moderator-master.blade.php -->
@section('moderator-css-styles')

@endsection

<!-- yield from component.app-base -->
@section('main')

    <script>
        $(document).ready(function(){

            /**
             * =============================================================================== 
             * Checking the category, post_state and from_account when page loads
             * ===============================================================================
             */

            window.onload = onPageLoad();
            function onPageLoad(){
                document.getElementById('{{$post->category_id}}').checked = true;
                // document.getElementById('{{$post->post_state}}').checked = true;
                // document.getElementById('{{$post->from_account}}').selected = true;
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
                                    let post_topic_id = '{{$post->topic_id}}';
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

            /**
             * =============================================================================== 
             * Count the remaining characters for summary textarea
             * ===============================================================================
             */

            $("#summary").keyup(function(){
                $("#count").text("Characters left: " + (300 - $(this).val().length));
            });

        });
    </script>

    <h1>Edit Post</h1>

    <form action="{{route('update-post', $post->id)}}" method="POST" id="editPost" enctype="multipart/form-data">
        @csrf

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
                   placeholder=""
                   value="{{$post->title}}" 
                   aria-describedby="">
            @error('title')
                <div><h4 class="error">{{ $message }}</h4></div>
            @enderror
        </div>
        <br>



        

        <!-- Categories -->
        <div class="">
            <div>
                <label for="category_id">Category: <span class="form_required">*</span></label>
                <div>(section of email digest that message appears)</div>
            </div>

            @foreach($categories as $category)
                <div class="categories">
                    <input type="radio" 
                        name="category_id" 
                        id="{{$category->id}}"
                        value="{{$category->id}}"
                        class="">
                    <label for="category_id">{{$category->name}}</label>
                </div>
            @endforeach
            @error('category_id')
                <div><h4 class="error">{{ $message }}</h4></div>
            @enderror
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
                <label for="from_account">Posted By: <span class="form_required">*</span></label>
            </div>
            <select name="from_account" id="from_account">
                <!-- Replace netID with authorized current user's actual netID -->
                <option name="from_account" id="{{$netID}}" value="{{$netID}}">{{$netID}}</option>
                <!-- Make a table of alternative accounts to post from & loop through them -->
                @foreach($accounts as $account)
                <option name="from_account" id="{{$account->name}}" value="{{$account->name}}">{{$account->name}}</option>
                <!-- <option value="Coles College">Coles College</option>
                <option value="College of Computing">College of Computing</option> -->
                @endforeach
            </select>
            @error('from_account')
                <div><h4 class="error">{{ $message }}</h4></div>
            @enderror
        </div>
        <br>



        <!-- Summary -->
        <div class="">
            <div>
                <label for="summary">Summary: <span class="form_required">*</span></label>
                <div>(brief description that appears in email digest)</div>
            </div>
            <textarea name="summary" id="summary" class="" cols="30" rows="5" maxlength="300">{{$post->summary}}</textarea>
            <div id="count"></div>
            @error('summary')
                <div><h4 class="error">{{ $message }}</h4></div>
            @enderror
        </div>
        <br>


        <!-- Full Message -->
        <div class="">
            <div>
                <label for="full_message">Full Message: <span class="form_required">*</span></label>
                <div>(entire content of message)</div>
            </div>
            <textarea name="full_message" id="full_message" class="" cols="30" rows="10" maxlength="5000">{{$post->full_message}}</textarea>
            @error('full_message')
                <div><h4 class="error">{{ $message }}</h4></div>
            @enderror
        </div>
        <br>


        <!-- Image -->
        <div class="">
            <div>
                <label for="image">Image:</label>
                <div>(picture related to post, optional, a default image will appear if none uploaded. Note: images are displayed in landscape at 1:1.5 aspect ratio)</div>
            </div>
            <div><img height="150px" width="150px" src="{{ asset('/storage/' . $post->image) }}" alt="image for the post"></div>
            <input type="file" 
                   name="image" 
                   id="image"
                   class="">
            <!-- Add a way to remove the image and replace it -->
            @error('image')
                <div><h4 class="error">{{ $message }}</h4></div>
            @enderror
        </div>
        <br>

        <!-- File Attachment -->
        <div class="">
            <div>
                <label for="file_attach">File Attachment:</label>
            </div>
            @if($post->file_attach != null && $post->file_attach != 'Temporary file_attach')
                <div>  
                    <a href="{{route('file.get-file', $post->id)}}">{{$file_name}}</a>
                </div>
            @endif
            <input type="file" 
                   name="file_attach" 
                   id="file_attach"
                   class="">

            @error('file_attach')
                <div><h4 class="error">{{ $message }}</h4></div>
            @enderror
        </div>
        <br>

        <!-- Shouldnt be able to edit post_state from edit post page -->
        {{--
            <!-- Need to use jQuery to dynamically set the 'selected' post_state -->
            <!-- Post State -->
            <div class="">
                <!-- Make a Categories table in the database and loop through to display categories -->
                <div>
                    <label for="post_state">Post State: *</label>
                </div>
                <input type="radio" 
                    name="post_state" 
                    id="Needs Review"
                    value="Needs Review"
                    class="">
                <label for="post_state">Needs Review</label><br>

                <input type="radio" 
                    name="post_state"
                    id="Publish"  
                    value="Publish" 
                    class="">
                <label for="post_state">Publish</label><br>

            </div>
        --}}
        <br>


        <button type="submit" class="btn search-btn">Update</button>
        <button type="submit" formaction="{{route('edit-post-preview', $post->id)}}" class="btn search-btn">Preview</button>
        
    </form>


@endsection
