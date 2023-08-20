<!-- ====================================================================================================== 
 * Moderator read my posts view   
 
 * URL - APP_URL/read-my-posts

 * CHILD VIEW of - moderator.moderator-master      
 
 * What page is doing:
    - shows all posts that were created by user, regardless of post_state

 * Controller 
    - PageController@readMyPosts -> ModeratorController@readMyPosts()
        > route - /read-my-posts
    - PageController@showPost -> ModeratorController@showPost() when user clicks on post title or 'read more'
        > route - /post/{post}
    - AjaxController@liveSearchMyPosts() when user inputs search
        > route - /live-search-my-posts

 * JS file 
    - app/public/js/read-my-posts.js
    - app/public/js/root.js

 * CSS file
    - 
 ====================================================================================================== -->



@extends('moderator.moderator-master')

<!-- yield from moderator.moderator-master -->
@section('moderator-js-scripts')
    <script src="{{asset('js/read-my-posts.js')}}"></script>
@endsection

<!-- yield from moderator.moderator-master -->
@section('moderator-css-styles')
    
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
                                <div class="post-list-state"><p class="right">Post Status: <span class="bold">{{$post->post_state}}</span></p></div>
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