@extends('components.app-base')

<!-- 
    This is the view that the user will be routed to when they log in and 
    the user's role is 'inactive' in the database.

    When user logs into SAML, in the middleware, check is the user is inactive.
    IF inactive, re-route user to this view.

    If the user is 'inactive', the user is logged out of the app. logged out 
    of SAML, and routed to this view.
 -->

@section('main')


    <div class="inner_rim">

        <div role="main" class="site_wrapper">
                
            <h1>Logged Out</h1>
            <p>You currently do not have access to KSU Today</p>



        </div>

    </div>

    
@endsection