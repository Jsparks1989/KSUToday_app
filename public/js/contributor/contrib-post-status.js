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

        // input#posts_status_search
        let contrib_posts_status_search = $("#contrib_posts_status_search");

        let user_id = $("#user_id");

        // query sent to ajax calls
        var query = {
            'posts_status': '',
            'user_id': ''
        };


        // load posts and pagination
        // posts retrieved depends on query & pagination page the user is on
        // retrieves all posts if query is empty
        function posts_status_search(page, query = ''){
            $.ajax({
                url: '/live-search-contrib-posts-status',
                type: 'get',
                dataType:'json',
                data:{page:page, query:query},
                success:function(data) {
                    $(posts_list).html(data.table);
                    $(pagination).html(data.pagination);
                    // console.log(data.query);
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }

    /**
     * =============================================================================== 
     * Ajax Live Search Below This Line
     * ===============================================================================
     */

    posts_status_search(1);


    // Return posts when user enters search
    $(document).on('keyup', '.search_my_posts', function(){
        query['posts_status'] = $(contrib_posts_status_search).val();
        query['user_id'] = $(user_id).val();
        posts_status_search(1, query);
    });


    // Return posts when user enters search and chooses pagination page
    $(document).on('click', '.page_link', function(){
        let page = $(this).data('page_number');
        query['posts_status'] = $(contrib_posts_status_search).val();
        query['user_id'] = $(user_id).val();
        posts_status_search(page, query);
        
    });
    
});



(function () { GLOBAL_scriptsLoaded.push( 'contrib-post-status.js' ) })();