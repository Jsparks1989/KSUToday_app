<!-- ====================================================================================================== 
 * Moderator moderate posts view   
 
 * URL - APP_URL/moderate-posts

 * CHILD VIEW of - moderator.moderator-master      
 
 * What page is doing:
    - lists all posts where post_state != 'Published'
    - user can change post_state for each post in drop-down
    - user can edit post by clicking 'edit post' link
    - input search will search posts by 'title' & 'posted by' ('title' and 'from_account' in posts table)

 * Controller 
    - PageController@moderatePosts() -> ModeratorController@moderatePosts()
        > route - /moderate-posts

    - AjaxController@editPostState() when user updates post state
        > route - /update-post-state/{id}/{state}

    - AjaxController@liveSearchModPostsStatus() when user searches posts
        > route - /live-search-mod-posts-status

    - PageController@editPost() -> ModeratorController@editPost() when user clicks 'edit post'
        > route - /edit-post/{post}

 * JS file 
    - app/public/js/root.js
    - app/public/js/moderator/mod-moderate-posts.js
    - app/public/js/toastr.js
    - app/public/js/toast-messages.js

 * CSS file
    - 
 ====================================================================================================== -->




@extends('moderator.moderator-master')


<!-- yield from moderator-master.blade.php -->
@section('moderator-js-scripts')
    <script src="{{asset('js/moderator/mod-moderate-posts.js')}}"></script>
@endsection


<!-- yield from moderator-master.blade.php -->
@section('moderator-css-styles')

@endsection

<!-- yield from components.app-master -->
@section('main')

    <h1>Moderate Posts</h1>


    @include('components.sessions')


    <div class="container-box">
        <label for="title_summary">Search by Title & Posted By:</label>
        <input type="text" name="title_summary" class="search_my_posts" id="posts_status_search" placeholder="Search" />
        <!-- Hidden input field that passes in the Auth::user's id -->
        <input type="hidden" name="user_id" class="search_my_posts" id="user_id" value="{{Auth::user()->id}}">




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

                <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Posted By</th>
                        <th class="mp-update-at">Updated At</th>
                        <th class="mp-state">State</th>
                        <th>Edit</th>
                    </tr>
                </tfoot>

                <tbody id="posts_list">
                    
                </tbody>

            </table>

            <br>
            
            <div id="pagination"></div>
        </div>


    </div>
    
    <!-- Old table posts populate -->
    {{--
        <!-- <table class="table">

            <thead>
                <tr>
                <th>Title</th>
                <th>Posted By</th>
                <th class="mp-update-at">Updated At</th>
                <th class="mp-state">State</th>
                <th>Edit</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Posted By</th>
                    <th class="mp-update-at">Updated At</th>
                    <th class="mp-state">State</th>
                    <th>Edit</th>
                </tr>
            </tfoot>

            <tbody id="posts_list">
                
            </tbody>

        </table> -->
    --}}



    <!-- Old form to search for posts -->
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
                <label for="order_by">Order By:</label>
                <select name="order_by" class="form-input" id="order_by">
                    <option name="order_by" value="newest" selected>Newest</option>
                    <option name="order_by" value="oldest">Oldest</option>
                </select>
                <!-- </div> -->
            </div>
            <button id="submit_btn" class="btn search-btn" type="submit">Apply</button>
        </form>


        <table class="table">

            <thead>
                <tr>
                    <th>Title</th>
                    <th>Authored By</th>
                    <th>Updated At</th>
                    <th>State</th>
                    <th>Edit</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Authored By</th>
                    <th>Updated At</th>
                    <th>State</th>
                    <th>Edit</th>
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
                                    @endif
                                    @if($post->post_state == 'Publish')
                                        <option id="Needs Review" value="Needs Review">Needs Review</option>
                                        <option id="Publish" value="Publish" selected>Publish</option>
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

        <!-- pagination -->
        @if(isset($posts))
            {{$posts->links()}}
        @endif
    --}}
  
@endsection