<!-- ====================================================================================================== 
 * Moderator show post view   
 
 * URL - APP_URL/post/{post_id}

 * CHILD VIEW of - moderator.moderator-master      
 
 * What page is doing:
    - shows individual post when user clicks on post title or 'read more' from 'read posts' or 'read my posts'

 * Controller 
    - PageController@showPost() -> ModeratorController@showPost()
        > route - /post/{post}

 * JS file 
    - app/public/js/root.js

 * CSS file
    - 
 ====================================================================================================== -->




@extends('moderator.moderator-master')

<!-- yield from moderator.moderator-master -->
@section('moderator-css-styles')
    
@endsection

<!-- yield from moderator.moderator-master -->
@section('moderator-js-scripts')
    
@endsection

<!-- yield from component.app-base -->
@section('main')

    <!-- User shouldnt edit the post from preview, click browser back btn to edit -->
    {{--
        <div>
            <a href="{{route('moderator.edit-post', $post->id)}}"><button>Edit</button></a>
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