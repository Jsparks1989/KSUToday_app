

    <!-- 
        Styling from:
        css/ksu_css/navbar_user_menu.css
        css/ksu_css/sidebar.css 
    -->
    <li id="user_menu_gold_bar" class="dropdown">
    <a href="#">User Menu</a>
        <div class="sidebar" id="">

            <div class="dropdown-content secondary_nav">
            <!-- <div class="secondary_nav"> -->

                <ul>
                    @if(Auth::user()->role_id == 2)
                        <li class="sidebar-background"><a class="sidebar-background sidebar-link" href="{{route('read-my-posts')}}">Read My Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-background sidebar-link" href="{{route('post-status')}}">View Status of Posts</a></li>
                    @elseif(Auth::user()->role_id == 3)
                        <li class="sidebar-background"><a class="sidebar-link" href="{{route('read-my-posts')}}">Read My Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="{{route('moderate-posts')}}">Moderate Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="{{route('moderate-contributors')}}">Moderate Contributors</a></li>
                    @elseif(Auth::user()->role_id == 4)
                        <li class="sidebar-background"><a class="sidebar-link" href="{{route('read-my-posts')}}">Read My Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="{{route('moderate-posts')}}">Moderate Posts</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="{{route('moderate-users')}}">Moderate Users</a></li>
                        <li class="sidebar-background"><a class="sidebar-link" href="{{route('settings')}}">Settings</a></li>
                    @endif
                        <li class="sidebar-background"><a class="sidebar-link" href="{{ route('logout-user') }}">Logout</a></li>
                </ul>
            </div>
        </div>  
    </li>