

        /*

        NOT SURE WHAT THIS IS USED FOR. NOT USED FOR ANYTHING

        */ 



        $(document).ready(function(){

            /**
             * =============================================================================== 
             * Checking the category, post_state and from_account when page loads
             * ===============================================================================
             */

            window.onload = onPageLoad();
            function onPageLoad(){
                document.getElementById('{{$post->category_id}}').checked = true;
                // document.getElementById('{{$post->post_state}}').checked = true;
                // document.getElementById('{{$post->from_account}}').selected = true;
            }
            


            /**
             * =============================================================================== 
             * Displaying and fetching the topics
             * ===============================================================================
             */

            //-- Script that displays the Topics section when a Category is clicked
            $('input[name="category_id"]').click(function(){
                let catId = Number($('input[name="category_id"]:checked').attr('id'));
                fetchTopics(catId);
            });


            //-- Script that displays the Topics section when a Category has the 'checked' attribute
            if($('input[name="category_id"]:checked')){
                let catId = Number($('input[name="category_id"]:checked').attr('id'));
                fetchTopics(catId);
            }


            /**
             * =============================================================================== 
             * Ajax setup
             * ===============================================================================
             */

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            /**
             * =============================================================================== 
             * Define fetchTopics()
             * ===============================================================================
             */

            function fetchTopics(id){
                $.ajax({
                    url: '/get-topics/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                            let length = 0;
                            // Making sure the div holding the topics is empty
                            $('#topics_btns').empty();

                            if(response['topics'] != null){
                                // console.log('topics response not null:', response);
                                // setting response data array length to variable
                                length = response['topics'].length;

                                // if the length of the data array is longer than 0...
                                if(length > 0){
                                    // setting the $post->topic_id to variable
                                    let post_topic_id = '{{$post->topic_id}}';
                                    // loop through data array
                                    for(let i = 0; i < length; i++){
                                        // set topic attributes to variables
                                        let id = response['topics'][i].id;
                                        let category_id = response['topics'][i].category_id;
                                        let name = response['topics'][i].name;
                                        let created_at = response['topics'][i].created_at;
                                        let updated_at = response['topics'][i].updated_at;

                                        if(id == post_topic_id){
                                            let tr_str = "<div><input type='radio' name='topic_id' id='"+id+"' value='"+id+"' checked>"+
                                            "<label for='post_topic'>"+name+"</label></div>";
                                            $('#topics_btns').append(tr_str);
                                        } else {
                                            let tr_str = "<div><input type='radio' name='topic_id' id='"+id+"' value='"+id+"'>"+
                                            "<label for='post_topic'>"+name+"</label></div>";
                                            $('#topics_btns').append(tr_str);
                                        }
                                    }
                                }
                            }
                    }
                });
            }

            /**
             * =============================================================================== 
             * Count the remaining characters for summary textarea
             * ===============================================================================
             */

            $("#summary").keyup(function(){
                $("#count").text("Characters left: " + (300 - $(this).val().length));
            });

        });
