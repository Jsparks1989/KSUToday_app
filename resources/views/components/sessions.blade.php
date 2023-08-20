

<!-- 
    Process of Sessions working:
        1. flash session is set from controller
        2. when certain sessions are set, they create a certain div
        3. the divs are used for toast alerts to display

    Sessions are used for numerous things:
        1. creating posts
        2. updating posts / post status
        3. creating users / contributors
        4. updating users roles

    Just have to include('components.sessions') this file to any blade file that needs to check for sessions
 -->


<!-- yield from app-base.blade.php -->
@section('components-js-scripts')
    <!-- <script src="{{asset('js/create-post.js')}}"></script> -->
    <script src="{{asset('js/toast/toastr.js')}}"></script>
    <script src="{{asset('js/toast/toast-messages.js')}}"></script>
@endsection


<!-- yield from app-base.blade.php -->
@section('components-css-styles')
    <link href="{{asset('css/toastr.css')}}" rel="stylesheet">
@endsection

<div>
    @if(session('post-updated-message'))
        <div id="post_updated_success"></div>
    @elseif(session('post-created-message'))
        <div id="post_created_success"></div>
        
    @elseif(session('contributor-created-message'))
        <div id="contributor_created_success"></div>

    @elseif(session('user-created-message'))
        <div id="user_created_success"></div>

    @elseif(session('user-updated-message'))
        <div id="user_updated_success"></div>
        
    @endif
</div>