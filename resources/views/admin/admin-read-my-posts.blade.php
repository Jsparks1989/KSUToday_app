<!-- ====================================================================================================== 
 * Admin read my posts view   
 
 * URL - APP_URL/read-my-posts

 * CHILD VIEW of - admin.admin-master      
 
 * What page is doing:
    - shows all posts that were created by user, regardless of post_state

 * Controller 
    - PageController@readMyPosts -> AdminController@readMyPosts()
        > route - /read-my-posts
    - PageController@showPost -> AdminController@showPost() when user clicks on post title or 'read more'
        > route - /post/{post}
    - AjaxController@liveSearchMyPosts() populates page with posts & when user inputs search
        > route - /live-search-my-posts

 * JS file 
    - app/public/js/read-my-posts.js
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
    <script src="{{asset('js/read-my-posts.js')}}"></script>
@endsection

<!-- yield from component.app-base -->
@section('main')

    <h1>Read My Posts</h1>

    <div class="container-box">
        <label for="title_summary">Search by Title & Summary:</label>
        <input type="text" name="title_summary" class="search_my_posts" id="my_posts_search" placeholder="Search" />
        <!-- Hidden input field that passes in the Auth::user's id -->
        <input type="hidden" name="user_id" class="search_my_posts" id="user_id" value="{{Auth::user()->id}}">
        


        <div id="dynamic_content">
            <ul class="read-post-list">
            </ul>
            <br />
            <div id="pagination"></div>
        </div>
    </div>

@endsection