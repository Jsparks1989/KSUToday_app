

$(document).ready(function(){


    // Setting up ajax
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    /**
    * =============================================================================== 
    * Set/Define Variables & Functions
    * ===============================================================================
    */

        // ul.read-post-list
        let read_post_list = $('.read-post-list');

        // div#pagination
        let pagination = $('#pagination');

        // input#my_posts_search
        let my_posts_search = $("#my_posts_search");

        // input#user_id
        // pass the user's id to ajax to ensure the right posts are returned
        let user_id = $("#user_id");

        // search query sent to ajax
        let query = {
            'search_my_posts': '',
            'user_id': ''
        };



        // load posts and pagination
        // posts retrieved depends on query & pagination page the user is on
        // retrieves all posts if query is empty
        function get_my_posts(page, query = ''){
            $.ajax({
                url: '/live-search-my-posts',
                type: 'get',
                dataType:'json',
                data:{page:page, query:query},
                success: function(data) {
                    $(read_post_list).html(data.table);
                    $(pagination).html(data.pagination);
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }




    /**
    * =============================================================================== 
    * Get My Posts
    * ===============================================================================
    */
    
        // Get all my posts when page loads
        get_my_posts(1);


        // Return posts when user enters search
        $(document).on('keyup', '.search_my_posts', function(){
            query['search_my_posts'] = $(my_posts_search).val();
            query['user_id'] = $(user_id).val();
            get_my_posts(1, query);
        });



        // Return posts when user enters search and chooses pagination page
        $(document).on('click', '.page_link', function(){
            let page = $(this).data('page_number');
            query['search_my_posts'] = $(my_posts_search).val();
            query['user_id'] = $(user_id).val();
            get_my_posts(page, query);
        });

});


(function () { GLOBAL_scriptsLoaded.push( 'read-my-posts.js' ) })();