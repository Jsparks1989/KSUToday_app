<!-- ====================================================================================================== 
 * Contributor create post view   
 
 * URL - APP_URL/create-post

 * CHILD VIEW of - contributor.contributor-master    

 * What page is doing:
    - user creates new post
    - sections with red star are required; when form is sent to controller, form data is checked for validation
    - user can save the post, or preview the post and then save it
    - if the user does not upload an image, a stock image is used depending on the post category
 
 * Controller 
    - PageController@createPost() -> ContributorController@createPost()
        > route - /create-post
    - PageController@storePost() -> ContributorController@storePost() when form is submitted
        > route - /store-post

 * JS file 
    - app/public/js/root.js
    - app/public/js/create-post.js
    - app/public/js/toastr.js
    - app/public/js/toast-messages.js

 * CSS file
    - 
 ====================================================================================================== -->

@extends('contributor.contributor-master')

<!-- yield from contributor-master.blade.php -->
@section('contributor-js-scripts')
    <script src="{{asset('js/create-post.js')}}"></script>
@endsection


<!-- yield from contributor-master.blade.php -->
@section('contributor-css-styles')

@endsection

<!-- yield from component.app-base -->
@section('main')


    <!-- 
        * TinyMCE: WYSIWYG Editor
        * Documentation: https://www.tiny.cloud/docs/
        * Decided to not use
        * To use, just uncomment script tags below 
    -->
    <!-- 
        <script src="https://cdn.tiny.cloud/1/1v7knrx8m7z8k6gu5cozatz30kuypsr8ve5rq3853n67wawx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src='https://cdn.tiny.cloud/1/1v7knrx8m7z8k6gu5cozatz30kuypsr8ve5rq3853n67wawx/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#full_message'
            });
        </script> 
    -->


    <h1>Create Post</h1>

    @include('components.sessions')

    <form action="{{route('store-post')}}" method="POST" id="createPost" enctype="multipart/form-data">
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
                   placeholder="Enter Title" 
                   value="{{old('title')}}"
                   aria-describedby="">
            @error('title')
                <h4 class="error">{{ $message }}</h4>
            @enderror
        </div>
        <br>



        <!-- Categories -->
        <div class="">
            <div>
                <label for="category_id">Category: <span class="form_required">*</span></label>
            </div>

            @foreach($categories as $category)
            
                <div>
                    <input type="radio" 
                        name="category_id" 
                        id="{{$category->id}}"
                        value="{{$category->id}}"
                        <?php
                        // Input::old('category_id') == $category->id ? "checked": "";
                        ?>
                        class="">
                    <label for="category_id">{{$category->name}}</label>
                </div>
            @endforeach
            @error('category_id')
                <h4 class="error">{{ $message }}</h4>
            @enderror
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
                <label for="from_account">Posted By: <span class="form_required">*</span></label>
            </div>
            <select name="from_account" id="from_account">
                <!-- Replace netID with authorized current user's actual netID -->
                <option name="from_account" id="{{$netID}}" value="{{$netID}}">{{$netID}}</option>

                @foreach($accounts as $account)
                <option name="from_account" id="{{$account->name}}" value="{{$account->name}}">{{$account->name}}</option>
                @endforeach
            </select>
            
            @error('from_account')
                <h4 class="error">{{ $message }}</h4>
            @enderror
        </div>
        <br>



        <!-- Summary -->
        <div class="">
            <div>
                <label for="summary">Summary: <span class="form_required">*</span></label>
                <div>(brief description that appears in email digest)</div>
            </div>
            <textarea name="summary" id="summary" class="" cols="30" rows="5" maxlength="300">{{old('summary')}}</textarea>
            <div id="count"></div>
            @error('summary')
                <h4 class="error">{{ $message }}</h4>
            @enderror
        </div>
        <br>


        <!-- Full Message -->
        <div class="">
            <div>
                <label for="full_message">Full Message: <span class="form_required">*</span></label>
                <div>(entire content of message)</div>
            </div>
            <!-- <textarea name="full_message" id="full_message" class="" cols="30" rows="10"></textarea> -->
            <textarea name="full_message" class="" cols="30" rows="10">{{old('full_message')}}</textarea>
            @error('full_message')
                <h4 class="error">{{ $message }}</h4>
            @enderror
        </div>
        <br>


        <!-- Image -->
        <div class="">
            <label for="image">Image:</label>
            <!-- <div>(picture related to post, optional, a default image will appear if none uploaded. Note: images are displayed in landscape at 1:1.5 aspect ratio)</div> -->
            <input type="file" 
                   name="image" 
                   id="image"
                   class="">
            @error('image')
                <h4 class="error">{{ $message }}</h4>
            @enderror
        </div>
        <br>


        <!-- File Attachment -->
        <div class="">
            <label for="file_attach">File Attachment:</label>
            <input type="file" 
                   name="file_attach" 
                   id="file_attach"
                   class="">
            @error('file_attach')
                <h4 class="error">{{ $message }}</h4>
            @enderror
        </div>
        <br>

        <!-- User cannot set post_state for post -->
        {{--
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
        --}}
        <br>


        <button type="submit" class="submit_btn">Save</button>
        <button type="submit" formaction="{{route('post-preview')}}" class="submit_btn">Preview</button>
    </form>

@endsection