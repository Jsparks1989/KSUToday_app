
<!-- ====================================================================================================== -->
<!-- /                                                                                                      -->
<!-- Page that is displayed when user first goes to KSUToday app.                                           -->
<!-- Displays only a button that takes user to /login page                                                  -->
<!-- Dont need to worry about login/authentication/registration/change password for actual app              -->
<!-- The SLS will handle authentication                                                                     -->
<!-- What I need is to set the users info to SESSION so I can determine the proper controller/method to run -->
<!-- ====================================================================================================== -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KSUToday</title>
    <style>
        #header{
            background-color: lightblue;
            width:100%;
            height:100px;
            text-align: center;
        }

        #main{
            float:left;
            width:100%;
            background-color: lightgray;
        }

        #sidebar-right{
            float:left;
            width:30%;
            background-color: silver;
        }

        #footer{
            clear:both;
            height: 150px;
            width: 100%;
            text-align: center;
            background-color: lightblue;
        }

        #sidebar-left, #main, #sidebar-right{
            min-height: 600px				
        }
	</style>
</head>
<body>
    <div id="header">
        <h3>Header</h3>
    </div>

    <div id="main">
        <a href="{{route('login')}}">
            <button>Log In</button>
        </a>

        <div>
            @if(session('user-inactive'))
                <div><h4 class="success">{{ session('user-inactive') }}</h4></div>
            @endif
        </div>
    </div>

    <div id="footer">
        <h3>Footer</h3>
    </div>
</body>
</html>