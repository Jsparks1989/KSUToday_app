

$(document).ready(function(){

    // Setting up ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    /**
     * =============================================================================== 
     * Set/Define Variables and Functions
     * ===============================================================================
     */

        // tbody#posts_list
        let posts_list = $('#posts_list');

        // div#pagination
        let pagination = $('#pagination');

        // input#user_id
        // pass the user's id to ajax to ensure the right posts are returned
        let user_id = $("#user_id");

        // input#posts_status_search
        let posts_status_search = $("#posts_status_search");

        // input.search_my_posts
        let search_my_posts = $('.search_my_posts');

        // select.post_status_select
        let post_status_select = '.post_status_select';

        // a.page_link 
        let page_link = '.page_link';

        // search query sent to ajax
        let query = {
            'posts_status': '',
            'user_id': ''
        };

        // Update the post_state for post 
        function update_post_state(id, state) {
            $.ajax({
                url: '/update-post-state/' + id + '/' + state,
                type: 'get',
                dataType: 'json',
                success: function(response){

                }
            });
        }

        


        // load posts and pagination
        // posts retrieved depends on query & pagination page the user is on
        // retrieves all posts if query is empty
        function get_posts_moderate(page, query = ''){
            $.ajax({
                url: '/live-search-mod-posts-status',
                type: 'get',
                dataType:'json',
                data:{page:page, query:query},
                success: function(data) {
                    $(posts_list).html(data.table);
                    $(pagination).html(data.pagination);
                }
            });
        }


    /**
     * =============================================================================== 
     * Edit post_state of post
     * ===============================================================================
     */
     
        $("#dynamic_content").on('change', post_status_select, function(){
            let state = $(this).val();
            let id = $(this).prop('id');
            update_post_state(id, state);
        });   




    /**
     * =============================================================================== 
     * Display Posts
     * ===============================================================================
     */
        // Get all posts when page loads,
        get_posts_moderate(1);

        
        // Return posts when user enters search
        $(document).on('keyup', $(search_my_posts), function(){
            query['posts_status'] = $(posts_status_search).val();
            query['user_id'] = $(user_id).val();
            get_posts_moderate(1, query);
        });

        

        // Return posts when user changes category to search by
        $(document).on('click', '.page_link', function(){
            let page = $(this).data('page_number');
            query['posts_status'] = $(posts_status_search).val();
            query['user_id'] = $(user_id).val();
            get_posts_moderate(page, query);     
        });


    
});


(function () { GLOBAL_scriptsLoaded.push( 'mod-moderate-posts.js' ) })();