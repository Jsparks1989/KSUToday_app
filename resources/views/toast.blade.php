

<link href="{{ asset('css/toastr.css') }}" rel="stylesheet"/>

<script src="{{ asset('js/toastr.js') }}"></script>

<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('p').on('click', function() {
            toastr.success('You clicked a paragraph', '', {
                positionClass: 'toast-bottom-right',
            });
        });



    });


</script>