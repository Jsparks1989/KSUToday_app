<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Category;
use App\Topic;
use App\Post;
use App\User;
use App\DisplayPost;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/






/*

  NOTES FOR ROUTING: 
  ==================

  Routing Docs: https://laravel.com/docs/7.x/routing

  {post} - used in some routes when passing a Post object, not just an id.
           This is done in the app when viewing a post, or maybe editing a post.
           Instead of only passing the post id, laravel allows for the entire post object to be passed through.




  BREAKDOWN OF ROUTES & STEPS TO FOLLOW THEM
  ==========================================
  
  1. '/' - (the root) this is where SAML auth is. Once user logs in with SAML successfully, 
           their information is captured from SAML, checked against users table, then redirected to '/home'

  2. '/home' - This is where checkRole middleware is ran to determine the authorized user's role.
               Once their role is determined, they are redirected to their proper '/home-page'.

  3. Once the user logs in with SAML and is authorized by laravel, the pages the user is authorized to view
     is determined/loaded by PageController. Each method in PageController checks the auth'd user's role_id to 
     determine which controller to direct them to: UserController, ContributorController, ModeratorController, AdminController

  4. '/inactive-user', '/logout-user', '/digest/{post}' and file routes are outside the middleware group because the user does not have to 
     be authorized to view them.


*/






//-- After user logs in through SAML
Route::get('/', function () {

    /**
     * =============================================================================
     * Original Code 
     * =============================================================================
     */

          // return view('root-login');




    /**
     * =============================================================================
     * Grabs the MELLON data for user & authorizes user after SAML login
     * =============================================================================
     */

          //-- 1) Set the session data  
          foreach($_SERVER as $key => $value) {
            // dd($_SERVER);
              //-- Set User's role id
              if($key == 'MELLON_sys_affl_1') {
                if($value == 'EMPLOYEE' || $value == 'RETIREE' || $value == 'EMERITUS') {
                  $userData['role'] = 2;
                }
                if($value == 'STUDENT') {
                  $userData['role'] = 1;
                }
              } elseif($key == 'MELLON_sys_affl_2') {
                if($value == 'EXTEND_EMP') {
                  $userData['role'] = 2;
                }
              } 
              // if they log into SAML, but value not recognized, set user to user 
              else {
                $userData['role'] = 1;
              }


              // Set User's netID (name) & email
              if($key == 'MELLON_mail') {
                  $userData['netID'] = substr($value, 0, strpos($value, '@'));
                  $userData['email'] = $value;
              } elseif($key == 'MELLON_NAME_ID') {
                  $userData['netID'] = substr($value, 0, strpos($value, '@'));
                  $userData['email'] = $value;
              }

              // Set User's first name
              if($key == 'MELLON_givenName') {
                  $userData['firstName'] = $value;
              }

              // Set User's last name
              if($key == 'MELLON_sn') {
                  $userData['lastName'] = $value;
              }
          }
          
          session(['userData' => $userData]);
          $data = Request::session()->get('userData');

          

          //-- 2) Check Users table if user already exists
          // if (User::where('email', '=', $data['email'])->count() > 0){
          if (User::where('name', '=', $data['netID'])->count() > 0){
              // $user = User::where('email', $data['email'])->first();

              $user = User::where('name', $data['netID'])->first();

              // if user's email from SAML & users table are different, update user's email in users table
              if($user->email != $userData['email']) {
                $user->email = $userData['email'];
                $user->save();
              }


              // If user is inactive...
              if($user->role_id == 5){
                return redirect()->intended('/inactive-user');
              } else {
                Auth::loginUsingId($user->id);

                // redirects user to /home route
                return redirect()->intended('/home');
              }

          } else {
              // If user logs into SAML but not in user table...
              $user = new User;
              $user->role_id = $userData['role'];
              $user->name = $userData['netID'];
              $user->email = $userData['email'];
              $user->save();

              // dd();

              $new_user = User::where('email', $userData['email'])->first();
              Auth::loginUsingId($new_user->id);
              header('Location:'. $_SERVER['SERVER_NAME']);

              // redirects user to /home route
              return redirect()->intended('/home');
          }

})->name('root');

//-- unimportant. just a helper class that helps generate routes required for user authentication
Auth::routes();


//-- Routes for inactive user & logout. Not inside middleware('isAuthorized') bc inactive users are never authorized, so they have no access to app 
Route::get('/inactive-user', 'PageController@inactiveUser')->name('inactive-user');
Route::get('/logout-user', 'PageController@logoutUser')->name('logout-user');


//-- Route for anyone to view a post from the digest link
Route::get('/digest/{post}', 'DigestController@showPost')->name('digest-post');


//-- These routes cannot be inside middleware group because attachments must be accessible by outside users viewing digest links
Route::get('/file/download/{id}', 'FileController@downloadFile')->name('file.get-file');
Route::get('/file/show/{id}', 'FileController@getFile')->name('file.show-file');


//-- User must be logged in and authorized in order to use these routes
Route::middleware(['isAuthorized'])->group(function () {

  //-- This route runs middleware that re-directs user to their proper home-page
  Route::get('/home', ['middleware' => 'checkRole', function() {
    
  }]);


  Route::get('/home-page', 'PageController@homePage')->name('home-page');

  // Route::get('/home-page', function() {
  //   $page_length = DisplayPost::pluck('number_displayed')->first();
  //   echo $page_length;
  // });

  Route::get('/read-posts', 'PageController@readPosts')->name('read-posts');

  Route::get('/read-post-submit', 'PageController@readPostSubmit')->name('read-post-submit');

  Route::get('/create-post', 'PageController@createPost')->name('create-post');

  Route::get('/post/{post}', 'PageController@showPost')->name('show-post');

  Route::get('/read-my-posts', 'PageController@readMyPosts')->name('read-my-posts');

  Route::get('/posts-status', 'PageController@postsStatus')->name('post-status');

  Route::post('/store-post', 'PageController@storePost')->name('store-post');

  Route::post('/post-preview', 'PageController@postPreview')->name('post-preview');

  Route::get('/posts-status-submit', 'PageController@postsStatusSubmit')->name('posts-status-submit');

  Route::get('/store-preview-post', 'PageController@storePreviewPost')->name('store-preview-post');

  Route::get('/moderate-posts', 'PageController@moderatePosts')->name('moderate-posts');



  Route::get('/moderate-contributors', 'PageController@moderateContributors')->name('moderate-contributors');

  Route::post('/moderate-contributors/store', 'PageController@storeNewContributor')->name('store-new-contributors');

  Route::post('/moderate-contributors/search', 'PageController@searchContributorsSubmit')->name('search-contributors');



  Route::get('/moderate-posts', 'PageController@moderatePosts')->name('moderate-posts');

  Route::get('/moderate-posts-submit', 'PageController@moderatePostsSubmit')->name('moderate-posts-submit');

  Route::get('/edit-post/{post}', 'PageController@editPost')->name('edit-post');

  Route::post('/edit-post/{post}/post-preview', 'PageController@editPostPreview')->name('edit-post-preview');

  Route::post('/update-post/{post}', 'PageController@updatePost')->name('update-post');

  Route::get('/update-post/{post}/preview-post', 'PageController@updatePreviewPost')->name('update-preview-post');

  Route::get('/moderate-users', 'PageController@moderateUsers')->name('moderate-users');

  Route::post('/moderate-users/store', 'PageController@storeNewUser')->name('store-new-users');

  Route::post('/moderate-users/search', 'PageController@searchUserSubmit')->name('search-users');

  Route::get('/settings', 'PageController@settingsPage')->name('settings');

 


  //-- Ajax Routes
  //=====================


  /**
  * =============================================================================== 
  * USER ROUTES
  * ===============================================================================
  */    

  /**
  * =============================================================================== 
  * CONTRIBUTOR ROUTES
  * ===============================================================================
  */
    Route::middleware(['isContributor'])->group(function () {
      Route::get('/live-search-contrib-posts-status', 'AjaxController@liveSearchContribPostsStatus')->name('ajax.live-search-contrib-posts-status');
    });



  /**
  * =============================================================================== 
  * MODERATOR ROUTES
  * ===============================================================================
  */
    Route::middleware(['isModerator'])->group(function () {
      Route::get('/update-post-state/{id}/{state}', 'AjaxController@editPostState')->name('ajax.edit-post-state');
      Route::get('/live-search-mod-posts-status', 'AjaxController@liveSearchModPostsStatus')->name('ajax.live-search-mod-posts-status');
      Route::get('/live-search-contributors', 'AjaxController@liveSearchContributors')->name('ajax.live-search-contributors');
      Route::get('/add-contributor', 'AjaxController@addContributor')->name('ajax.add-contributor');
      Route::get('/get-current-user', 'AjaxController@getCurrentUser')->name('ajax.get-current-user');
      Route::get('/check-admin-email', 'AjaxController@checkAdminEmail')->name('ajax.check-admin-email');
      Route::get('/check-user-exists', 'AjaxController@checkIfUserExists')->name('ajax.check-user-exists');
    });



  /**
  * =============================================================================== 
  * ADMIN ROUTES
  * ===============================================================================
  */
    Route::middleware(['isAdmin'])->group(function () {
      Route::get('/update-post-state/{id}/{state}', 'AjaxController@editPostState')->name('ajax.edit-post-state');
      Route::get('/update-user-role/{id}/{role}', 'AjaxController@editUserRole')->name('ajax.edit-user-role');
      Route::get('/edit-user', 'AjaxController@editUser')->name('ajax.edit-user');
      Route::get('/live-search-admin-posts-status', 'AjaxController@liveSearchAdminPostsStatus')->name('ajax.live-search-admin-posts-status');
      Route::get('/add-user', 'AjaxController@addUser')->name('ajax.add-user');
      Route::get('/delete-user', 'AjaxController@deleteUser')->name('ajax.delete-user');
      
      //-- Admin Categories Tab
      Route::get('/get-categories', 'AjaxController@getCategories')->name('ajax.get-categories');
      Route::get('/get-categories-edit', 'AjaxController@getCategoriesEdit')->name('ajax.get-categories-edit');
      Route::get('/get-category/{id}', 'AjaxController@getCategory')->name('ajax.get-category');
      Route::get('/edit-category/{id}/{value}', 'AjaxController@editCategory')->name('ajax.edit-category');
      Route::get('/add-category', 'AjaxController@addCategory')->name('ajax.add-category');
      //-- Admin Alias Names Tab
      Route::get('/get-accounts', 'AjaxController@getAccounts')->name('ajax.get-accounts');
      Route::get('/get-accounts-edit', 'AjaxController@getAccountsEdit')->name('ajax.get-accounts-edit');
      Route::get('/get-account/{id}', 'AjaxController@getAccount')->name('ajax.get-account');
      Route::get('/edit-account/{id}/{value}', 'AjaxController@editAccount')->name('ajax.edit-account');
      Route::get('/add-account', 'AjaxController@addAccount')->name('ajax.add-account');
      Route::get('/check-user-exists', 'AjaxController@checkIfUserExists')->name('ajax.check-user-exists');
      Route::get('/search-users-pair-account', 'AjaxController@searchUsersPairAccount')->name('ajax.search-users-pair-account');
      Route::get('/detach-user-account-pair', 'AjaxController@detachUserAccountPair')->name('ajax.detach-user-account-pair');
      Route::get('/attach-user-account-pair', 'AjaxController@attachUserAccountPair')->name('ajax.attach-user-account-pair');
      
      Route::get('/get-all-toast-data', 'AjaxController@getAllToastData')->name('ajax.get-all-toast-data');
      Route::get('/add-new-toast-message', 'AjaxController@addNewToastMessage')->name('ajax.add-new-toast-message');
      Route::get('/set-toast-position-options', 'AjaxController@setToastPositionOptions')->name('ajax.set-toast-position-options');
      Route::get('/update-toast', 'AjaxController@updateToast')->name('ajax.update-toast');
      Route::get('/get-toasts', 'AjaxController@getToasts')->name('ajax.get-toasts');
      // Admin Settings 'General System Configurations' Tab
      Route::get('/get-digest-emails', 'AjaxController@getDigestEmails')->name('ajax.get-digest-emails');
      Route::get('/add-digest-email', 'AjaxController@addDigestEmail')->name('ajax.add-digest-email');
      Route::get('/update-cron-job-digest', 'AjaxController@updateCronJobDigest')->name('ajax.update-cron-job-digest');
      Route::get('/get-posts-per-page', 'AjaxController@getNumPostsDisplayed')->name('ajax.get-posts-per-page');
      Route::get('/update-num-displayed', 'AjaxController@updateNumDisplayed')->name('ajax.update-num-displayed');
    });



  /**
  * =============================================================================== 
  *  AJAX ROUTES - USED AMONG ALL USERS
  * ===============================================================================
  */
    Route::get('/get-topics/{id}', 'AjaxController@getTopics')->name('ajax.get-topics');
    Route::get('/live-search-read-posts', 'AjaxController@liveSearchReadPosts')->name('ajax.live-search-read-posts');
    




  /**
  * =============================================================================== 
  * NOT BEING USED
  * ===============================================================================
  */

    Route::get('/get-newest-posts', 'AjaxController@getNewestPosts')->name('ajax.get-newest-posts');
    Route::get('/get-oldest-posts', 'AjaxController@getOldestPosts')->name('ajax.get-oldest-posts');
    Route::get('/get-user/{id}', 'AjaxController@getUser')->name('ajax.get-user');
    Route::get('/search-title', 'AjaxController@searchPostTitle')->name('ajax.search-title');
    Route::get('/live-search-my-posts', 'AjaxController@liveSearchMyPosts')->name('ajax.live-search-my-posts');
    Route::get('/live-search-users', 'AjaxController@liveSearchUsers')->name('ajax.live-search-users');

        
        

});//-- End Route::middleware(['isAuthorized'])




      //-- User routes - NOT BEING USED
      /*
      
        //-- User Routes
        //==============
        // Route::get('/user', 'UserController@index')->name('home');

        // Route::get('/user/read-posts', 'UserController@readPosts')->name('home.read-posts');

        // Route::get('/user/read-posts-submit', 'UserController@readPostSubmit')->name('home.read-post-submit');


        // Route::get('/user/post/{post}', 'UserController@showPost')->name('home.show-post');
      
      */



      //-- Contributor routes - NOT BEING USED
      /*
      
        //-- Contributor Routes
        //=====================
        // Route::get('/contributor', 'ContributorController@index')->name('contributor.index');

        // Route::get('/contributor/read-posts', 'ContributorController@readPosts')->name('contributor.read-posts');
        // Route::get('/contributor/read-posts-submit', 'ContributorController@readPostSubmit')->name('contributor.read-post-submit');


        // Route::get('/contributor/create-post', 'ContributorController@createPost')->name('contributor.create-post');

        // Route::post('/contributor/post-preview', 'ContributorController@postPreview')->name('contributor.post-preview');


        // Route::post('/contributor/store-post', 'ContributorController@storePost')->name('contributor.store-post');
        // Route::get('/contributor/store-preview-post', 'ContributorController@storePreviewPost')->name('contributor.store-preview-post');


        // Route::get('/contributor/posts-status', 'ContributorController@postsStatus')->name('contributor.post-status');
        // Route::get('/contributor/posts-status-submit', 'ContributorController@postsStatusSubmit')->name('contributor.posts-status-submit');


        // Route::get('/contributor/read-my-posts', 'ContributorController@readMyPosts')->name('contributor.read-my-posts');

        // Route::get('/contributor/post/{post}', 'ContributorController@showPost')->name('contributor.show-post');
      
      */
        


      //-- Moderator routes - NOT BEING USED
      /*
        //-- Moderator routes
        //===================
        // Route::get('/moderator', 'ModeratorController@index')->name('moderator.index');


        // Route::get('/moderator/read-posts', 'ModeratorController@readPosts')->name('moderator.read-posts');
        // Route::get('/moderator/read-posts-submit', 'ModeratorController@readPostSubmit')->name('moderator.read-post-submit');


        // Route::get('/moderator/create-post', 'ModeratorController@createPost')->name('moderator.create-post');
        // Route::post('/moderator/create/post-preview', 'ModeratorController@createPostPreview')->name('moderator.create-post-preview');


        // Route::post('/moderator/store-post', 'ModeratorController@storePost')->name('moderator.store-post');


        // Route::get('/moderator/store-preview-post', 'ModeratorController@storePreviewPost')->name('moderator.store-preview-post');


        // Route::get('/moderator/read-my-posts', 'ModeratorController@readMyPosts')->name('moderator.read-my-posts');


        // Route::get('/moderator/add-contributors', 'ModeratorController@addContributors')->name('moderator.add-contributors');
        // Route::post('/moderator/add-contributors/store', 'ModeratorController@storeNewContributor')->name('moderator.store-new-contributors');
        // Route::post('/moderator/add-contributors/remove', 'ModeratorController@removeContributor')->name('moderator.remove-contributors');
        // Route::post('/moderator/search-contributors', 'ModeratorController@searchContributorsSubmit')->name('moderator.search-contributors');


        // Route::get('/moderator/post/{post}', 'ModeratorController@showPost')->name('moderator.show-post');


        // Route::get('/moderator/moderate-posts', 'ModeratorController@moderatePosts')->name('moderator.moderate-posts');
        // Route::get('/moderator/moderate-posts-submit', 'ModeratorController@moderatePostsSubmit')->name('moderator.moderate-posts-submit');


        // Route::get('/moderator/edit-post/{post}', 'ModeratorController@editPost')->name('moderator.edit-post');
        // Route::post('/moderator/update-post/{post}', 'ModeratorController@updatePost')->name('moderator.update-post');

        // Route::post('/moderator/edit/{post}/post-preview', 'ModeratorController@editPostPreview')->name('moderator.edit-post-preview');
        // Route::get('/moderator/update/{post}/preview-post', 'ModeratorController@updatePreviewPost')->name('moderator.update-preview-post');
      
      */
        


      //-- Admin routes - NOT BEING USED
      /*
      
        //-- Admin
        //========
        // Route::get('/admin', 'AdminController@index')->name('admin.index');

        // Route::get('/admin/read-posts', 'AdminController@readPosts')->name('admin.read-posts');
        // Route::get('/admin/read-posts-submit', 'AdminController@readPostSubmit')->name('admin.read-post-submit');

        // Route::get('/admin/create-post', 'AdminController@createPost')->name('admin.create-post');
        // Route::post('/admin/create/post-preview', 'AdminController@createPostPreview')->name('admin.create-post-preview');


        // Route::post('/admin/store-post', 'AdminController@storePost')->name('admin.store-post');
        // Route::get('/admin/store-preview-post', 'AdminController@storePreviewPost')->name('admin.store-preview-post');

        // Route::get('/admin/edit-post/{post}', 'AdminController@editPost')->name('admin.edit-post');
        // Route::post('/admin/update-post/{post}', 'AdminController@updatePost')->name('admin.update-post');


        // Route::get('/admin/read-my-posts', 'AdminController@readMyPosts')->name('admin.read-my-posts');


        // Route::post('/admin/edit/{post}/post-preview', 'AdminController@editPostPreview')->name('admin.edit-post-preview');
        // Route::get('/admin/update/{post}/preview-post', 'AdminController@updatePreviewPost')->name('admin.update-preview-post');

        // Route::get('/admin/moderate-users', 'AdminController@addUsers')->name('admin.moderate-users');
        // Route::post('/admin/moderate-users/search', 'AdminController@searchUserSubmit')->name('admin.search-users');
        // Route::post('/admin/moderate-users/store', 'AdminController@storeNewUser')->name('admin.store-new-users');
        // Route::post('/admin/moderate-users/remove', 'AdminController@removeUser')->name('admin.remove-users');
        // Route::post('/admin/moderate-users/edit', 'AdminController@updateUser')->name('admin.update-users');

        // Route::get('/admin/post/{post}', 'AdminController@showPost')->name('admin.show-post');

        // Route::get('/admin/moderate-posts', 'AdminController@moderatePosts')->name('admin.moderate-posts');
        // Route::get('/admin/moderate-posts-submit', 'AdminController@moderatePostsSubmit')->name('admin.moderate-posts-submit');
      
      */
        


