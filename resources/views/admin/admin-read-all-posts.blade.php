<!-- ====================================================================================================== 
 * Admin read all posts view   
 
 * URL - APP_URL/read-posts

 * CHILD VIEW of - admin.admin-master      
 
 * What page is doing:
    - shows all posts with post_state = 'Published'

 * Controller 
    - PageController@readPosts -> AdminController@readPosts()
        > route - /read-posts
    - PageController@showPost -> AdminController@showPost() when user clicks on post title or 'read more'
        > route - /post/{post}
    - AjaxController@liveSearchReadPosts() populates page wit posts & when user inputs search
        > route - /live-search-read-posts

 * JS file 
    - app/public/js/read-all-posts.js
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
    <script src="{{asset('js/read-all-posts.js')}}"></script>
@endsection


<!-- yield from component.app-base -->
@section('main')


    
    

    <h1>Read Posts</h1>

    <div class="container-box">
        <label for="title">Title:</label>
        <input type="text" name="title" class="search_posts" id="title_search" placeholder="Enter Title" />

        <label for="accounts_select">Posted By:</label>
        <input type="text" name="netID" class="search_posts" id="posted_by_search" placeholder="Enter netID" />

        <!-- Categories -->
        <!-- <div class="form-input"> -->
        <label for="categories">Category:</label>
        <select name="categories_select" id="categories">
                <option name="category_item" id="category" value="0" selected>- All Categories -</option>
            @foreach($categories as $category)
                <option name="category_item" id="category" value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        <!-- </div> -->
        




        <div id="dynamic_content">
            <ul class="read-post-list">
            </ul>
            <br />
            <div id="pagination"></div>
        </div>
    </div>


@endsection