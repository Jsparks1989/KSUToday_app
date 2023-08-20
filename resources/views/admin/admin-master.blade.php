<!-- ====================================================================================================== 
 * PARENT VIEW for ADMIN after the user logs in and is authenticated as a admin  

 * Extends from components.app-master

 * each section('') are yielded at components.app-base
 
 * section('css-styles') & section('js-scripts')
    - files that go here will be included on every blade file that extends from 
      moderator.moderator-master
    - yield('moderator-css-styles') & yield('moderator-js-scripts') allows for 
      js & css files to be included only on specific pages
      
 * section('navbar') & section('sidebar-right')
    - includes links only available for admin

 * Controller - n/a

 * Route - n/a

 * JS file 
    - n/a

 * CSS file
    - 
 ====================================================================================================== -->

@extends('components.app-master')

<!-- yield from app-base.blade.php -->
@section('css-styles')
    @yield('admin-css-styles')
@endsection


<!-- yield from app-base.blade.php -->
@section('js-scripts')
    @yield('admin-js-scripts')
    <script src="{{asset('js/toast/global-toast-variables-functions.js')}}"></script>
@endsection

<!-- yield from app-base.blade.php -->
@section('navbar')
    <li><a href="{{route('home-page')}}">Home</a></li>
    <li><a href="{{route('read-posts')}}">Read Posts</a></li>
    <li><a href="{{route('create-post')}}">Create Post</a></li>

    <!-- Include "User Menu" when window shrinks to certain size -->
    @include('components.navbar-user-menu')
@endsection

<!-- yield from app-master.blade.php -->
@section('sidebar-right')
    <li class="sidebar-background"><a class="sidebar-link" href="{{route('read-my-posts')}}">Read My Posts</a></li>
    <li class="sidebar-background"><a class="sidebar-link" href="{{route('moderate-posts')}}">Moderate Posts</a></li>
    <li class="sidebar-background"><a class="sidebar-link" href="{{route('moderate-users')}}">Moderate Users</a></li>
    <li class="sidebar-background"><a class="sidebar-link" href="{{route('settings')}}">Settings</a></li>
@endsection

