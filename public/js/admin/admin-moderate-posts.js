


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

        // query passed into posts_status_live_search()
        let query = {
            'posts_status': '',
            // 'user_id': ''
        };

        // tbody#posts_list
        let posts_list =  $('#posts_list');

        // div#pagination
        let pagination = $('#pagination');

        // div#dynamic_content
        let dynamic_content = $('#dynamic_content');

        // input#posts_status_search
        let posts_status_search = $('#posts_status_search');

        // populate page with posts & pagination
        function posts_status_live_search(page, query = ''){
            $.ajax({
                url: '/live-search-admin-posts-status',
                type: 'get',
                data:{page:page, query:query},
                dataType:'json',
                success: function(data) {
                    $(posts_list).html(data.table);
                    $(pagination).html(data.pagination);
                }
            });
        }



    /**
     * =============================================================================== 
     * Edit post_state of post onchange()
     * ===============================================================================
     */

        // when user changes the posts status
        $(dynamic_content).on('change', '.post_status_select', function(){
            let state = $(this).val();
            let id = $(this).prop('id');

            $.ajax({
                url: '/update-post-state/' + id + '/' + state,
                type: 'get',
                dataType: 'json',
                success: function(response){
                    // console.log('response: ', response);
                }
            });
        });


    /**
     * =============================================================================== 
     * Display Posts
     * ===============================================================================
     */

        // display posts immediately
        posts_status_live_search(1);
    


        // display posts based on search input
        $(document).on('keyup', '.search_my_posts', function(){
            query['posts_status'] = $(posts_status_search).val();
            posts_status_live_search(1, query);
        });



        // display posts based on pagination page user clicked
        $(document).on('click', '.page_link', function(){
            var page = $(this).data('page_number');
            query['posts_status'] = $(posts_status_search).val();
            posts_status_live_search(page, query);
            
        });
    
});

(function () { GLOBAL_scriptsLoaded.push( 'admin-moderate-posts.js' ) })();