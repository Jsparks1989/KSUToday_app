@extends('components.app-master')


<!-- yield from app-base.blade.php -->
@section('css-styles')
    @yield('user-css-styles')
@endsection

<!-- yield from app-base.blade.php -->
@section('js-scripts')
    @yield('user-js-scripts')
@endsection

<!-- yield from app-base.blade.php -->
@section('navbar')
    <li><a href="{{route('home-page')}}">Home</a></li>  
    <li><a href="{{route('read-posts')}}">Read Posts</a></li>
    @include('components.navbar-user-menu')  
@endsection