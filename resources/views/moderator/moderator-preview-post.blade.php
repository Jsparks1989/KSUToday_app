<!-- ====================================================================================================== 
 * Moderator posts status view   
 
 * URL - APP_URL/post-preview

 * CHILD VIEW of - moderator.moderator-master      
 
 * What page is doing:
    - when user creates a new post, hit Preview btn
    - allows user to preview how the new post will look before submitting
    - user can click the back btn on browser to return to APP_URL/create-post

 * Controller 
    - PageController@postPreview() -> ModeratorController@postPreview()
        > route - /post-preview    

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

    <div class="sp-container">
        <h1>{{$inputs['title']}}</h1>

        {{--<p class="sp-created-at"><em>{{$post->created_at}}</em></p>--}}
        <p class="sp-posted-by"><span class="right"> Posted By: <span class="bold">{{$inputs['from_account']}}</span></span></p>


        <span class="sp-category"><span class="right bold">{{$inputs['category_name']}}</span></span>



        <div class="sp-full-message"><p>{{$inputs['full_message']}}</p></div>
        <div class="sp-image"><img width="535px" height="360px" src="{{ asset('/storage/' . $inputs['image']) }}" alt="image for the post"></div>




        @if($inputs['file_attach'] != null && $inputs['file_attach'] != 'Temporary file_attach')
            <!-- <h3>Attached File:</h3> -->
            {{--<a href="{{route('file.get-file', $post->id)}}">{{$inputs['file_name']}} </a>--}}
            <p class="bold sp-file-attach">View Attachment</p>
        @endif



        <a href="{{route('store-preview-post' )}}" ><button class="submit_btn">Save</button></a>
    </div>


@endsection