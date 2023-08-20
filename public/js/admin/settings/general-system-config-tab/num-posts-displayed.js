$(document).ready(function(){

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
        
        //select#posts_per_page_select
        let posts_per_page_select = $('#posts_per_page_select');


        // append <options> to select#posts_per_page_select
        function populatePostsPerPageOptions() {
            $.ajax({
                url: '/get-posts-per-page',
                type: 'get',
                // data: {num:num},
                dataType: 'json',
                success: function(data){
                    for(let i = 1; i <= data.max_num_of_posts; i++) {
                        if(i == data.num_of_posts) {
                            $(posts_per_page_select).append($('<option>', {
                                value: i,
                                text: i,
                                selected: 'selected'
                            }));
                        } else {
                            $(posts_per_page_select).append($('<option>', {
                                value: i,
                                text: i,
                            }));
                        }
                    }
                    console.log(data);
                }, 
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }

        // update number_displayed in display_posts table
        function updateNumDisplayed(num) {
            return new Promise ((resolve, reject) => {
                $.ajax({
                    url: '/update-num-displayed',
                    data: {num:num},
                    type: 'get',
                    dataType: 'json',
                    success: resolve, 
                    error: reject,
                });
            });
        }



    /**
    * =============================================================================== 
    * Populate 'Number of Posts Displayed per Page'
    * ===============================================================================
    */ 

        populatePostsPerPageOptions();




    /**
    * =============================================================================== 
    * Update number of posts able to be displayed
    * ===============================================================================
    */
        // when user changes the value of position or message for any of the toasts
        $(posts_per_page_select).on('change', function() {

            let num_of_posts = $(this).val();
            // console.log(num_of_posts);
            updateNumDisplayed(num_of_posts).then((resolve) => {
                // console.log(resolve);
            }).catch((reject) => {
                // console.log(reject);
            });
        });



        
});