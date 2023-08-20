



/*
        

    NOT USING. IGNORE 


*/


        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });




           /**
            * =============================================================================== 
            * Get Categories
            * ===============================================================================
            */

            function get_categories(){
                $.ajax({
                    url: '/get-categories-edit',
                    type: 'get',
                    // data: {query:query},
                    dataType: 'json',
                    success: function(data) {
                        // $('tbody').html(data.table_data);
                        $('#categories_list').html(data.output);
                        // $('#total_records').text(data.total_data);
                        console.log('data', data);

                    }
                });
            }
            get_categories();

        });

      



        (function () { GLOBAL_scriptsLoaded.push( 'admin-settings.js' ) })();