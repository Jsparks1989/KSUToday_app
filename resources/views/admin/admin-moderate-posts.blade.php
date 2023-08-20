<!-- ====================================================================================================== 
 * Admin moderate posts view   
 
 * URL - APP_URL/moderate-posts

 * CHILD VIEW of - admin.admin-master      
 
 * What page is doing:
    - lists all posts regardless of post_state
    - user can change post_state for each post in drop-down
    - user can edit post by clicking 'edit post' link
    - input search will search posts by 'title' & 'posted by' ('title' and 'from_account' in posts table)

 * Controller 
    - PageController@moderatePosts() -> AdminController@moderatePosts()
        > route - /moderate-posts

    - AjaxController@editPostState() when user updates post state
        > route - /update-post-state/{id}/{state}

    - AjaxController@liveSearchAdminPostsStatus() display posts and when user searches posts
        > route - /live-search-admin-posts-status

    - PageController@editPost() -> ModeratorController@editPost() when user clicks 'edit post'
        > route - /edit-post/{post}

 * JS file 
    - app/public/js/root.js
    - app/public/js/admin/admin-moderate-posts.js
    - app/public/js/toast/global-toast-variables-functions.js
    - app/public/js/toast/toastr.js
    - app/public/js/toast/toast-messages.js

 * CSS file
    - 
 ====================================================================================================== -->



@extends('admin.admin-master')


<!-- yield from admin-master.blade.php -->
@section('admin-js-scripts')
    <script src="{{asset('js/admin/admin-moderate-posts.js')}}"></script>
@endsection


<!-- yield from admin-master.blade.php -->
@section('admin-css-styles')

@endsection

<!-- yield from components.app-master -->
@section('main')


    @include('components.sessions')
    

    <h1>Moderate Posts</h1>

    
    <div class="container-box">
        <label for="title_summary">Search by Title & Posted By:</label>
        <input type="text" name="title_summary" class="search_my_posts" id="posts_status_search" placeholder="Search" />
        <!-- Hidden input field that passes in the Auth::user's id -->
        <input type="hidden" name="user_id" class="search_my_posts" id="user_id" value="{{Auth::user()->id}}">
    </div>






    <div id="dynamic_content">

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Posted By</th>
                    <th class="mp-update-at">Updated At</th>
                    <th class="mp-state">State</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody id="posts_list">


            </tbody>
            <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Posted By</th>
                    <th class="mp-update-at">Updated At</th>
                    <th class="mp-state">State</th>
                    <th>Edit</th>
                </tr>
            </tfoot>
        </table>
        <br />

        <div id="pagination"></div>

    </div>


    <!-- Old Form -->
    {{--
        <form action="{{ route('moderate-posts-submit') }}" method="get" enctype="multipart/form-data">
            @csrf

            <div class="form-container">
                <!-- Search by Post Title -->
                <!-- <div class="form-input"> -->
                    <label for="title">Title:</label>
                    <input type="text" name="title"></input>
                <!-- </div> -->





                <!-- accounts -->
                <!-- <div class="form-input"> -->
                    <label for="accounts_select">Account:</label>
                    <select name="accounts_select" id="accounts_select">
                            <option name="account_option" id="account_option_default" value="0" selected>- Accounts -</option>
                        @foreach($accounts as $account)
                            <option name="account_option" id="account_option" value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach  
                            <option name="account_option" id="account_netID" value="netID">- Search By netID -</option>
                    </select>
                <!-- </div> -->
                <br>
            



                <!-- netID -->
                <div id="netID_section" hidden>
                    <label for="netID">netID:</label>
                    <input type="text" name="netID"></input>
                </div>
                <br>





                    <!-- Categories -->
                    <!-- <div class="form-input"> -->
                        <label for="categories">Category:</label>
                        <select name="categories_select" id="categories">
                                <option name="category_item" id="category" value="0" selected>- Categories -</option>
                            @foreach($categories as $category)
                                <option name="category_item" id="category" value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    <!-- </div> -->

                    <!-- Topics -->
                    <div id="topics" hidden>
                            <label for="topics">Topic:</label>
                            <select name="topics_select" id="topics">
                                <option class="leave_me" name="topic_item" id="topic" value="0" selected>- Topics -</option>
                            </select>
                    </div>                
            

                <!-- <div > -->
                <select name="order_by" class="form-input" id="order_by">
                    <option name="order_by" value="newest" selected>Newest</option>
                    <option name="order_by" value="oldest">Oldest</option>
                </select>
                <!-- </div> -->
            </div>
            <button id="submit_btn" class="btn search-btn" type="submit">Apply</button>
        </form>
    --}}

    <!-- Old DataTale -->
    {{--
        <table class="table">

            <thead>
                <tr>
                    <th>Title</th>
                    <th>Authored By</th>
                    <th>Updated At</th>
                    <th>State</th>
                    <th>Edit Post</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Authored By</th>
                    <th>Updated At</th>
                    <th>State</th>
                    <th>Edit Post</th>
                </tr>
            </tfoot>

            <tbody>
                @if(isset($posts))
                    @foreach($posts as $post)
                        <tr>
                            <td>{{$post->title}}</td>
                            <td>{{$post->from_account}}</td>
                            <td>{{$post->created_at}}</td>
                            <td>
                                <select id="{{ $post->id }}" name="post_state_select">
                                    @if($post->post_state == 'Needs Review')
                                        <option id="Needs Review" value="Needs Review" selected>Needs Review</option>
                                        <option id="Publish" value="Publish">Publish</option>
                                        <option id="Published" value="Published">Published</option>
                                    @endif
                                    @if($post->post_state == 'Publish')
                                        <option id="Needs Review" value="Needs Review">Needs Review</option>
                                        <option id="Publish" value="Publish" selected>Publish</option>
                                        <option id="Published" value="Published">Published</option>
                                    @endif
                                    @if($post->post_state == 'Published')
                                        <option id="Needs Review" value="Needs Review">Needs Review</option>
                                        <option id="Publish" value="Publish">Publish</option>
                                        <option id="Published" value="Published" selected>Published</option>
                                    @endif
                                        
                                </select>
                            </td>
                            <td><a href="{{route('edit-post', $post->id)}}" class="btn btn-login">Edit Post</a></td>
                        </tr>
                    @endforeach
                @endif

                @if(isset($noPosts))
                    <h2>{{ $noPosts }}</h2>
                @endif
            </tbody>
        </table>
    --}}
@endsection

