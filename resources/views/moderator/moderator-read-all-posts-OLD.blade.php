

@extends('moderator.moderator-master')



@section('main')


    <script>
        $(document).ready(function(){

            load_data(1);

            function load_data(page, query = '') {
                $.ajax({
                url:'/live-search-read-posts',
                method:"get",
                data:{page:page, query:query},
                success:function(data)
                {
                    // $('#dynamic_content').html(data.output);
                    $('#dynamic_content').html(data);
                }
                });
            }






            // When user clicks li.page-item > a.page-link in pagination
            $(document).on('click', '.page-link', function(){
                var page = $(this).data('page_number');
                console.log('click .page-link page: ', page);
                let query = {
                    'title': '',
                    'from_account': '',
                    'category' : ''
                };
                query['title'] = $("#title_search").val();
                query['from_account'] = $("#posted_by_search").val();
                query['category'] = $('#categories').val();
                // var query = $('#search_box').val();
                load_data(page, query);
                
            });

            // When user enters search query
            $(document).on('keyup', '.search_posts', function(){
                let query = {
                    'title': '',
                    'from_account': '',
                    'category' : ''
                };

                query['title'] = $("#title_search").val();
                query['from_account'] = $("#posted_by_search").val();
                query['category'] = $('#categories').val();

                // live_search_read_posts(query);
                // console.log('query: ', query);
                load_data(1, query);
            });


            // When user chooses categoy in search query
            $('#categories').change(function() {
                let query = {
                    'title': '',
                    'from_account': '',
                    'category' : ''
                };

                query['title'] = $("#title_search").val();
                query['from_account'] = $("#posted_by_search").val();
                query['category'] = $('#categories').val();

                // live_search_read_posts(query);
                // console.log('search: ', query);
                load_data(1, query);
            });

        });
</script>





















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
            
        </div>


        
    </div>

    {{--
        <form action="{{ route('read-post-submit') }}" method="get"  enctype="multipart/form-data">
            @csrf
            <div>
                <!-- Search by Post Title -->
                <!-- <div class="form-input"> -->
                    <label for="title">Title:</label>
                    <!-- php code to keep input value after form is submitted -->
                    <input type="text" name="title" value="<?php echo isset($_GET['title']) ? htmlspecialchars($_GET['title'], ENT_QUOTES) : '';?>"></input>
                <!-- </div> -->



                <!-- accounts -->
                <!-- <div class="form-input"> -->
                    <label for="accounts_select">Posted By:</label>
                    <select name="accounts_select" id="accounts_select">
                            <option name="account_option" id="account_option_default" value="0" selected>- Accounts -</option>
                        @foreach($accounts as $account)
                            <option name="account_option" id="account_option" value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach  
                            <option name="account_option" id="account_netID" value="netID">- Search By netID -</option>
                    </select>
                <!-- </div> -->
                <br>        
                <?php
                    if(isset($_GET['accounts_select'])){
                ?>
                    <!-- Keep input value for select#accounts_select after form submission -->
                    <script type="text/javascript">
                        // if(document.getElementById('accounts_select').value != '0') {
                            document.getElementById('accounts_select').value = "<?php echo $_GET['accounts_select']; ?>";
                        // }
                    </script>
                <?php } ?>





                <!-- netID -->
                <!-- php that determines if this div stays hidden or not after form is submitted -->
                <div id="netID_section" hidden<?php echo isset($_GET['accounts_select']) && $_GET['accounts_select'] == 'netID' ? 'hidden' : '';?>>
                    <label for="netID">netID:</label>
                    <!-- php that keeps input value after form is submitted -->
                    <input type="text" name="netID" value="<?php echo isset($_GET['netID']) ? htmlspecialchars($_GET['netID'], ENT_QUOTES) : '';?>"></input>
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
                    <?php
                        if(isset($_GET['categories_select'])){
                    ?>
                        <!-- Keep input value for select#accounts_select after form submission -->
                        <script type="text/javascript">
                            document.getElementById('categories').value = "<?php echo $_GET['categories_select']; ?>";
                        </script>
                    <?php } ?>



                    <!-- Topics -->
                    <!-- php that determines if topics div should be hidden or displayed -->
                    <?php 
                        if(isset($_GET['categories_select']) && $_GET['categories_select'] != '0'){
                    ?>
                        <div id="topics_div">
                    <?php } else {?>
                        <div id="topics_div" hidden>
                    <?php }?>
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
                <?php
                    if(isset($_GET['order_by'])){
                ?>
                    <!-- Keep input value for select#accounts_select after form submission -->
                    <script type="text/javascript">
                        // if(document.getElementById('accounts_select').value != '0') {
                            document.getElementById('order_by').value = "<?php echo $_GET['order_by']; ?>";
                        // }
                    </script>
                <?php } ?>
            </div>
            <!-- <div class="outer_rim"> -->
                <button id="submit_btn" class="submit_btn" type="submit">Apply</button>
            <!-- </div> -->
            
        </form>
    --}}




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