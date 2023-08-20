<!-- ====================================================================================================== 
 * Admin edit post preview view   
 
 * URL - APP_URL/edit-post/{post}/post-preview

 * CHILD VIEW of - moderator.moderator-master  
    - admin-edit-posts ->[click 'Preview']-> admin-edit-post-preview
 
 
 * What page is doing:
    - user can see how the post will look with the edits before saving it
    - user can click browser back btn to go back and edit more or save

 * Controller 
    - PageController@editPostPreview() -> AdminController@editPostPreview()
        > route - /edit-post/{post}/post-preview

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
    <div class="sp-container">
        <h1>{{$inputs['title']}}</h1>

        {{--<p class="sp-created-at"><em>{{$post->created_at}}</em></p>--}}
        <p class="sp-posted-by"><span class="right"> Posted By: <span class="bold">{{$inputs['from_account']}}</span></span></p>


        <span class="sp-category"><span class="right bold">{{$inputs['category_name']}}</span></span>


        <div class="sp-image">
            <img src="{{ asset('/storage/' . $inputs['image']) }}" alt="image for the post">
        </div>


        <div class="sp-full-message">
            <p>{{$inputs['full_message']}}</p>

            @if($inputs['file_attach'] != null && $inputs['file_attach'] != 'Temporary file_attach')
                <!-- <h3>Attached File:</h3> -->
                {{--<a href="{{route('file.get-file', $post->id)}}">{{$inputs['file_name']}} </a>--}}
                <p class="bold">View Attachment</p>
            @endif
        </div>

        




        



        {{--<a href="{{route('update-preview-post' )}}"><button class="submit-btn">Save</button></a>--}}
    </div>
@endsection





