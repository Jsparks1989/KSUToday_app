<!-- ====================================================================================================== 
 * Contributor posts status view   
 
 * URL - APP_URL/posts-status

 * CHILD VIEW of - contributor.contributor-master      
 
 * Ajax call builds out table of all the posts made by the user
    - posts are appended to tbody#posts_list
    - pagination is appended to div#pagination

 * Controller
    - PageController@postsStatus() -> ContributorController@postsStatus()
        > route - /posts-status
    - AjaxContributor@liveSearchContribPostsStatus() when inputing search
        > route - /live-search-contrib-posts-status

 * JS file 
    - app/public/js/contributor/contrib-post-status.js
    - app/public/js/root.js

 * CSS file
    - 
 ====================================================================================================== -->




@extends('contributor.contributor-master')

<!-- yield from component.app-base -->
@section('main')

    <script src="{{asset('js/contributor/contrib-post-status.js')}}"></script>

    <h1>Posts Status</h1>

    <div class="container-box">
        <label for="title_summary">Search by Title:</label>
        <input type="text" name="title_summary" class="search_my_posts" id="contrib_posts_status_search" placeholder="Search" />
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
                </tr>
            </tfoot>
        </table>
        <br />

        <div id="pagination"></div>
        </div>
        
    </div>

    
    
    <!-- Old form -->
    {{--
        <form action="{{ route('posts-status-submit') }}" method="get" enctype="multipart/form-data">
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

    <!-- Old table -->
    {{--
        <!-- DataTales Example -->
        <!-- <div class=""> -->
            
            <!-- <div class=""> -->
                <!-- <div class=""> -->
                    <table class="table">

                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Authored By</th>
                                <th>Updated At</th>
                                <th>State</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Title</th>
                                <th>Authored By</th>
                                <th>Updated At</th>
                                <th>State</th>
                            </tr>
                        </tfoot>

                        <tbody>
                            @if(isset($posts))
                                @foreach($posts as $post)
                                    <tr>
                                        <td>{{$post->title}}</td>
                                        <td>{{$post->from_account}}</td>
                                        <td>{{$post->updated_at}}</td>
                                        <td>{{$post->post_state}}</td>
                                    </tr>
                                @endforeach
                            @endif

                            @if(isset($noPosts))
                                <h2>{{ $noPosts }}</h2>
                            @endif
                        </tbody>

                    </table>

                    
                    @if(isset($posts))
                        {{$posts->links()}}
                    @endif
    
                <!-- </div> -->
            <!-- </div> -->
        <!-- </div> -->
    --}}

    
@endsection



