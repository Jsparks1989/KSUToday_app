<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;


/*

    BREAKDOWN OF PAGE CONTROLLER
    ============================

    This is the main controller that will determine what pages users can view based on their role.

    * Each method queries the authorized user.
        - If no user is authorized, session data is flushed & redirected immediately to logout page.
        - If a user is authorized, their role is checked and they are directed to their appropriate page.


*/


class PageController extends Controller
{
    //
    protected $user;

    public function __construct() {
        
    }

    


    public function inactiveUser() {
        // if(Auth::check()){
        //     return Auth::user();
        // } else {
        //     return 'No user is authorized';
        // }
        session(['user-inactive'=>'You currently do not have access to KSU Today']);
        return view('components.logout');
        // return session('user-inactive');
    }


    public function logoutUser() {
        session()->flush();
        Auth::logout();
        return view('components.logout');
        // if(Auth::check()){
        //     return Auth::user();
        // } else {
        //     return 'No user is authorized';
        // }
    }


    public function homePage() {

        //-- Try/Catch for "ErrorException -> Trying to get property 'id' of non-object"
        
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            //-- If no user is logged in (authorized), redirect immediately to logout
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }


        if($user->isUser()){
            $controller = app()->make('App\Http\Controllers\UserController')->index();
            return $controller;

            // echo 'User is a user';   
            // Auth::logout();
        }


        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->index();
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }


        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->index();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->index();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }


        
    }



    public function readPosts() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }
        
        if($user->isUser()){
            $controller = app()->make('App\Http\Controllers\UserController')->readPosts();
            return $controller;

            // echo 'User is a user';   
            // Auth::logout();
        }


        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->readPosts();
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }


        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->readPosts();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->readPosts();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }


        
    }


    public function readPostSubmit() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }
        
        if($user->isUser()){
            $controller = app()->make('App\Http\Controllers\UserController')->readPostSubmit();
            return $controller;

            // echo 'User is a user';   
            // Auth::logout();
        }


        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->readPostSubmit();
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }


        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->readPostSubmit();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->readPostSubmit();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }
    }


    public function showPost(Post $post) {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }
        
        if($user->isUser()){
            $controller = app()->make('App\Http\Controllers\UserController')->showPost($post);
            return $controller;

            // echo 'User is a user';   
            // Auth::logout();
        }


        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->showPost($post);
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }


        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->showPost($post);
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->showPost($post);
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }
    }


    public function createPost() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->createPost();
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }


        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->createPost();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->createPost();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }
    }


    public function readMyPosts() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->readMyPosts();
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }


        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->readMyPosts();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->readMyPosts();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }
    }


    public function postsStatus() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }


        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->postsStatus();
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }
    }


    public function storePost() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->storePost();
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }


        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->storePost();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->storePost();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }
    }


    public function postPreview() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->postPreview();
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }


        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->createPostPreview();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->createPostPreview();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }
    }


    public function storePreviewPost(Request $request) {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->storePreviewPost($request);
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }


        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->storePreviewPost($request);
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->index();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }
    }


    public function postsStatusSubmit() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isContributor()){
            $controller = app()->make('App\Http\Controllers\ContributorController')->postsStatusSubmit();
            return $controller;

            // echo 'User is a contributor'; 
            // Auth::logout();    
        }
    }


    public function moderatePosts() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->moderatePosts();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->moderatePosts();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }
    }


    public function moderatePostsSubmit() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->moderatePostsSubmit();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }


        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->moderatePostsSubmit();
            return $controller; 

            // echo 'User is a admin';  
            // Auth::logout();    
        }
    }


    public function moderateContributors() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->moderateContributors();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }


    public function storeNewContributor() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->storeNewContributor();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }


    public function searchContributorsSubmit() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->searchContributorsSubmit();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }


    public function editPost(Post $post) {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->editPost($post);
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }

        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->editPost($post);
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }


    public function editPostPreview(Post $post) {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->editPostPreview($post);
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }

        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->editPostPreview($post);
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }


    public function updatePost(Post $post) {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isModerator()){
            $controller = app()->make('App\Http\Controllers\ModeratorController')->updatePost($post);
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }

        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->updatePost($post);
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }


    public function moderateUsers() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->moderateUsers();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }


    public function storeNewUser() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->storeNewUser();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }


    public function searchUserSubmit() {
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->searchUserSubmit();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }


    public function settingsPage() {;
        try {
            $user = User::findOrFail(Auth::user()->id);
        } catch (\Exception $exception) {
            // return redirect()->intended('/');
            // return 'No user logged in';
            session()->flush();
            Auth::logout();
            return view('components.logout');
        }

        if($user->isAdmin()){
            $controller = app()->make('App\Http\Controllers\AdminController')->adminSettings();
            return $controller;   

            // echo 'User is a moderator';   
            // Auth::logout();
        }
    }

    
}
