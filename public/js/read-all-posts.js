

$(document).ready(function(){

    /**
    * =============================================================================== 
    * Set/Define Variables & Functions
    * ===============================================================================
    */

        // ul.read-post-list
        let read_post_list_ul = $('.read-post-list');

        // div#pagination 
        let read_post_list_pagination = $('#pagination');

        // search query sent to ajax
        let query = {
            'title': '',
            'from_account': '',
            'category' : ''
        };

        // search input
        let search_title = $('#title_search');
        let search_posted_by = $('#posted_by_search');
        let search_categories_select = $('#categories');


        // load posts and pagination
        // posts retrieved depends on query & pagination page the user is on
        // retrieves all posts if query is empty
        function get_posts(page, query = '') {
            $.ajax({
            url:'/live-search-read-posts',
            method:"get",
            dataType:'json',
            data:{page:page, query:query},
            success:function(data) {
                $(read_post_list_ul).html(data.table);
                $(read_post_list_pagination).html(data.pagination);
            }
            });
        }


    /**
    * =============================================================================== 
    * Get All Posts
    * ===============================================================================
    */

        // Get all posts when page loads, 
        get_posts(1);

        // Return posts when user enters search and chooses pagination page 
        $(document).on('click', '.page_link', function(){
            var page = $(this).data('page_number');
            query['title'] = $(search_title).val();
            query['from_account'] = $(search_posted_by).val();
            query['category'] = $(search_categories_select).val();
            get_posts(page, query);
        });




        // Return posts when user enters search
        $(document).on('keyup', '.search_posts', function(){
            query['title'] = $(search_title).val();
            query['from_account'] = $(search_posted_by).val();
            query['category'] = $(search_categories_select).val();

            get_posts(1, query);
        });


        // Return posts when user changes category to search by
        $('#categories').change(function() {
            query['title'] = $(search_title).val();
            query['from_account'] = $(search_posted_by).val();
            query['category'] = $(search_categories_select).val();

            get_posts(1, query);
        });

});



(function () { GLOBAL_scriptsLoaded.push( 'read-all-posts.js' ) })();