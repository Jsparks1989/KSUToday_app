@extends('components.app-base')


@section('main')

<script>

    // logs user out
    function logout(){
        console.log("logout");
        window.location.reload();
        // destroy cookie to prevent bad logout
        document.cookie = "mellon-cookie=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        // window.location = "https://intweb.kennesaw.edu/mellon/logout?ReturnTo=https://intweb.kennesaw.edu/loggedout.php";

        // window.location = "http://ksutodaytest.kennesaw.edu/mellon/logout?ReturnTo=http://ksutodaytest.kennesaw.edu/public/index.php";
        window.location = "http://ksutodaytest.kennesaw.edu/mellon/logout?ReturnTo=http://ksutodaytest.kennesaw.edu/public/index.php";
    }


    // logout button (in header)
    // logout.click(function(e){
    //     e.preventDefault();
    //     logout();
    // });

</script>


    <div class="inner_rim">

        <div role="main" class="site_wrapper">

            @if(session('user-inactive'))
                <h4>{{ session('user-inactive') }}</h4>
                <a onclick="logout()" href="#" class="btn btn-login">LOG IN</a>
            @else
                <h1>Logged Out</h1>
                <p>You have successfully logged out.</p>

                {{--<a href="{{route('root')}}" class="btn btn-login">LOG IN</a>--}}
                <a onclick="logout()" href="#" class="btn btn-login">LOG IN</a>
            @endif

            

        </div>

    </div>

    
@endsection