@extends('components.app-base')


@section('main')

      







<div class="inner_rim">

    <div role="main" class="site_wrapper">
            
        <p>KSU Today is Kennesaw State University's system for posting and viewing campus announcements for faculty&nbsp;and staff.</p>
        <p>To access KSU Today, please log-in with your full KSU email address and&nbsp;<a href="https://netid.kennesaw.edu" title="KSU NetID">NetID&nbsp;password</a>.&nbsp; KSU Today uses Duo two-factor authentication; <a href="https://uits.kennesaw.edu/duo" title="KSU two-factor authentication">learn more here</a>.</p>

        <div class="center">
            <a href="{{route('login')}}" class="btn btn-login">LOG IN</a>
        </div>

        <div>
            @if(session('user-inactive'))
                <div><h4 class="error">{{ session('user-inactive') }}</h4></div>
            @endif
        </div>

        {{$_SERVER}}

    </div>

</div>



    


    
@endsection