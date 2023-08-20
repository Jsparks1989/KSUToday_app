<!-- ====================================================================================================== 
 * User read all posts view   
 
 * URL - APP_URL/read-posts

 * CHILD VIEW of - user.user-master      
 
 * What page is doing:
    - shows all posts with post_state = 'Published'

 * Controller 
    - PageController@readPosts -> UserController@readPosts()
        > route - /read-posts
    - PageController@showPost -> UserController@showPost() when user clicks on post title or 'read more'
        > route - /post/{post}
    - AjaxController@liveSearchReadPosts() populates page with posts & when user inputs search
        > route - /live-search-read-posts

 * JS file 
    - app/public/js/read-all-posts.js
    - app/public/js/root.js

 * CSS file
    - 
 ====================================================================================================== -->

@extends('user.user-master')

<!-- yield from user.user-master -->
@section('user-css-styles')
    
@endsection

<!-- yield from user.user-master -->
@section('user-js-scripts')
    <script src="{{asset('js/read-all-posts.js')}}"></script>
@endsection

<!-- yield from component.app-base -->
@section('main')

    <h1>Read Posts</h1>

    <div class="container-box">
        <!-- Title Input -->
        <label for="title">Title:</label>
        <input type="text" name="title" class="search_posts" id="title_search" placeholder="Search Posts by Title" />

        <!-- Posted_By Input -->
        <label for="accounts_select">Posted By:</label>
        <input type="text" name="netID" class="search_posts" id="posted_by_search" placeholder="Search Posts by netID" />

        <!-- Categories -->
        <label for="categories">Category:</label>
        <select name="categories_select" id="categories">
                <option name="category_item" id="category" value="0" selected>- All Categories -</option>
            @foreach($categories as $category)
                <option name="category_item" id="category" value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        

        <div id="dynamic_content">
            <ul class="read-post-list">
            </ul>
            <br />
            <div id="pagination"></div>
        </div>
    </div>

@endsection