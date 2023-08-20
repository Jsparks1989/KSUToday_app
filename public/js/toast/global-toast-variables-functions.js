
/*

    CANT FIGURE OUT WHY GLOBALS ARENT AVAILABLE ON OTHER JS FILES.
    IGNORE THIS FILE UNTIL FIGURED OUT WHY.

*/ 

$(document).ready(function(){

    // Setting up ajax
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });


   /**
    * =============================================================================== 
    * Globals for Toasts
    * ===============================================================================
    */

        var global_toast_messages;
        function set_global_toast_messages(data) {
            global_toast_messages = data;
        }

        var global_toast_positions;
        function set_global_toast_positions(data) {
            global_toast_positions = data;
        }
        
        var global_toasts;
        function set_global_toasts(data) {
            global_toasts = data;
        }

        // get all toast data and set them to global variables
        function getAllToastData() {
            return new Promise ((resolve, reject) => {
                $.ajax({
                    url: '/get-all-toast-data',
                    type: 'get',
                    // data: {query:query},
                    dataType: 'json',
                    success: resolve,
                });
            });  
        }
        // getAllToastData().then((resolve) => {
        //     console.log(resolve);
        //     set_global_toast_messages(resolve.messages);
        //     set_global_toast_positions(resolve.positions);
        //     set_global_toasts(resolve.toasts);
        // });
        
        
    
});

/**
* =============================================================================== 
* 
* ===============================================================================
*/





    (function () { GLOBAL_scriptsLoaded.push( 'global-variables-functions.js' ) })();