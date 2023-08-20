<!-- ====================================================================================================== 
 * Moderator read all posts view   
 
 * URL - APP_URL/read-posts

 * CHILD VIEW of - moderator.moderator-master      
 
 * What page is doing:
    - shows all posts with post_state = 'Published'

 * Controller 
    - PageController@readPosts -> ModeratorController@readPosts()
        > route - /read-posts
    - PageController@showPost -> ModeratorController@showPost() when user clicks on post title or 'read more'
        > route - /post/{post}
    - AjaxController@liveSearchReadPosts() populates page with posts & when user inputs search
        > route - /live-search-read-posts

 * JS file 
    - app/public/js/read-all-posts.js
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


    <script src="{{asset('js/read-all-posts.js')}}"></script>

    <h1>Read Posts</h1>

    <div class="container-box">
        <label for="title">Title:</label>
        <input type="text" name="title" class="search_posts" id="title_search" placeholder="Search Posts by Title" />

        <label for="accounts_select">Posted By:</label>
        <input type="text" name="netID" class="search_posts" id="posted_by_search" placeholder="Search Posts by netID" />

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




    {{--
        <ul class="read-post-list">
            @if(isset($posts))
                @foreach($posts as $post)
                    <li class="li-wrapper">
                        <div class="post-list-img">
                            <img  src="{{ asset('/storage/' . $post->image) }}" alt="image for the post">
                        </div>
                        <div class="post-list-content">
                            <h2><a href="{{route('show-post', $post->id)}}">{{$post->title}}</a></h2>

                            <!-- <div class="li-wrapper"> -->
                                <div class="post-list-created-at"><p><em>{{$post->created_at}}</em></p></div>
                                <div class="post-list-posted-by"><p class="right">Posted By: <span class="bold">{{$post->from_account}}</span></p></div>
                            <!-- </div> -->

                            <p class="post-list-summary">{{Str::limit($post->summary, 100)}}</p>

                            <p class="post-list-category">Category: <span class="bold">{{$post->category->name}}</span></p>

                            <p class="post-list-read-more"><a href="{{route('show-post', $post->id)}}">Read More &rarr;</a></p>

                        </div>
                        
                    </li> 
                    <hr>
                @endforeach
            @endif
        </ul>


        @if(isset($noPosts))
            <h2>{{ $noPosts }}</h2>
        @endif

        <!-- pagination -->
        @if(isset($posts))
            {{$posts->links()}}
        @endif
    --}}
@endsection