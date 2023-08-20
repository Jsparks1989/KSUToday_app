<!-- ====================================================================================================== 
 * PARENT VIEW for CONTRIBUTOR after the user logs in and is authenticated as a contributor  

 * Extends from components.app-master

 * each section('') are yielded at components.app-base
 
 * section('css-styles') & section('js-scripts')
    - files that go here will be included on every blade file that extends from 
      contributor.contributor-master
    - yield('contributor-css-styles') & yield('contributor-js-scripts') allows for 
      js & css files to be included only on specific pages
      
 * section('navbar') & section('sidebar-right')
    - includes links only available for contributors

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
    @yield('contributor-css-styles')
@endsection

<!-- yield from app-base.blade.php -->
@section('js-scripts')
    @yield('contributor-js-scripts')
@endsection

<!-- yield from app-base.blade.php -->
@section('navbar')
    <li><a href="{{route('home-page')}}">Home</a></li>
    <li><a href="{{route('read-posts')}}">Read Posts</a></li>
    <li><a href="{{route('create-post')}}">Create Post</a></li>
    @include('components.navbar-user-menu')
@endsection

<!-- yield from app-master.blade.php -->
@section('sidebar-right')
    <li class="sidebar-background"><a class="sidebar-link" href="{{route('read-my-posts')}}">Read My Posts</a></li>
    <li class="sidebar-background"><a class="sidebar-link" href="{{route('post-status')}}">View Status of Posts</a></li>
@endsection


  