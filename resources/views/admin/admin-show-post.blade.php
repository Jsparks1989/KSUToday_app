<!-- ====================================================================================================== 
 * Admin show post view   
 
 * URL - APP_URL/post/{post_id}

 * CHILD VIEW of - admin.admin-master      
 
 * What page is doing:
    - shows individual post when user clicks on post title or 'read more' from read-posts or read-my-posts

 * Controller 
    - PageController@showPost() -> AdminController@showPost()
        > route - /post/{post}

 * JS file 
    - app/public/js/root.js
    - app/public/js/toast/global-toast-variables-functions.js

 * CSS file
    - 
 ====================================================================================================== -->






@extends('admin.admin-master')

<!-- yield from admin.admin-master -->
@section('admin-css-styles')
    
@endsection

<!-- yield from admin.admin-master -->
@section('admin-js-scripts')
    
@endsection

<!-- yield from component.app-base -->
@section('main')

    {{--
        <div>
            <a href="{{route('admin.edit-post', $post->id)}}"><button>Edit</button></a>
        </div>
    --}}
    <div class="sp-container">
        <h1>{{$post->title}}</h1>

        <p class="sp-created-at"><em>{{ date('m-d-Y',strtotime($post->created_at)) }}</em></p>

        <p class="sp-posted-by"><span class="right"> Posted By: <span class="bold">{{$post->from_account}}</span></span></p>


        <span class="sp-category"><span class="right bold">{{$post->category->name}}</span></span>

        <div class="sp-image">
            <img src="{{ asset('/storage/' . $post->image) }}" alt="image for the post">
        </div>

        <div class="sp-full-message">
            <p>{{$post->full_message}}</p>

            @if($post->file_attach != null && $post->file_attach != 'Temporary file_attach')
                <!-- <h3>Attached File:</h3> -->
                <a href="{{route('file.get-file', $post->id)}}">View Attachment</a>
            @endif
        </div>
        {{--
            <div class="sp-image"><img width="535px" height="360px" src="{{ asset('/storage/' . $post->image) }}" alt="image for the post"></div>
        --}}
        

    </div>

@endsection