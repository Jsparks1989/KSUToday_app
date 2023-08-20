
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

            // categories input
            let category_id = $('input[name="category_id"]');

            // div#post_topics
            let post_topics = $('#post_topics');


            // textarea#summary
            let summary = $('#summary');

            // div#count
            let count = $("#count");


            // Fetch topics associated with selected category and append them to div#post_topics
            function fetchTopics(id){
                $.ajax({
                    url: '/get-topics/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                            let length = 0;
                            let topics = response['topics'];
                            let topics_btns = $('#topics_btns');
                            // Make sure the div#topics_btns is empty
                            $(topics_btns).empty();

                            // Make sure ajax returned topics associated with selected category
                            if(topics != null){
                                length = topics.length;
                                if(length > 0){
                                    // Build the topic radio buttons
                                    for(let i = 0; i < length; i++){
                                        // set topic attributes to variables
                                        let id = topics[i].id;
                                        let name = topics[i].name;;
                                        let tr_str = "<div><input type='radio' name='topic_id' id='"+id+"' value='"+id+"'>"+
                                        "<label for='post_topic'>"+name+"</label></div>";
                                        // append topic radio btns to div#topics_btns
                                        $(topics_btns).append(tr_str);
                                    }
                                }
                            }
                    }
                });
            }


        /**
         * =============================================================================== 
         * Display/Hide topics associated with Categories
         * ===============================================================================
         */

            //-- When category radio btn is clicked, fetch topics
            $(category_id).click(function(){
                // Display topics 
                $(post_topics).show();
                // Set chosen category->id to var
                let catId = $(this).attr('id');
                fetchTopics(catId);
            });

        /**
         * =============================================================================== 
         * Count the remaining characters for summary textarea
         * ===============================================================================
         */

            $(summary).keyup(function(){
                $(count).text("Characters left: " + (300 - $(this).val().length));
            });

    });


    (function () { GLOBAL_scriptsLoaded.push( 'create-post.js' ) })();
