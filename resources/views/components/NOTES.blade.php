


<!-- 
    NOTES:
    1. General notes on how Laravel works
        * Follows MVC architecture

        * @yield('') goes in parent view, can be acquired by child view with @section(''). Both must have same name.
            - @section('') inputs content where the same @yield('') is defined

        * {{-- --}} comment tags for laravel

        * 



    2. General setup of application
        * CONTROLLERS - app/Http/Controllers - Where all Controllers are located.
            - PageController
                + This controller is where all routes (excluding ajax routes) will lead to.
                + Each method in this controller will check the auth'd user's role_id, and go to
                  their proper controller and method.
                    ~ Ex. Scenario: An admin going to home-page.
                          Whats Happening: 1. user goes to route '/home-page'
                                           2. the route goes to PageController@homePage()
                                           3. homePage() gets user's role_id
                                           4. returns AdminController@index()

                + This controller was added so the urls are all the same despite the users' roles
                + This controller mainly is used when visiting a page
                + The routes to this controller are all locked behind isAuthorized middleware

            - AjaxController
                + This controller is where all ajax calls are ran.
                + This controller loads dynamic content on pages
                    ~ Ex. When user is searching for posts/users, the list of posts/users and pagination
                + The routes to this controller are all locked behind middlewares that check auth'd user's role

            - AdminController
                + This controller deals with only admin routes and views
                + Views: app/

            - ModeratorController
                + This controller deals with only moderator routes and views

            - ContributorController
                + This controller deals with only contributor routes and views

            - UserController
                + This controller deals with only user routes and views

        * MIDDLEWARES - app/Http/Middleware - Where all the middlewares are located
            - code that acts as a bridge (filter) between requests and responses.

            - When adding a new middleware, you have to add it to $routeMiddleware array, or else it
              will not be accessable. 
                + $routeMiddleware location - app/Http/Kernel.php

            - CheckRole.php
                + checks if the current authorized user exists in users table
                + will redirect the user depending on if the user exists and 
                  what the user's role is

            - isAuthorized.php
                + checks for authorized user and if the user exists in users table

            - IsUser.php
                + checks if the current authorized user is a user
            
            - IsContributor.php
                + checks if the current authorized user is a contributor
                
            - IsModerator.php
                + checks if the current authorized user is a moderator
                
            - IsAdmin.php
                + checks if the current authorized user is an admin
                
            - IsBanned.php
                + checks if the current authorized user is banned
                
            

        * VIEWS - resources/views - Where all the viewable (blade) files are located
            - Views are broken up by role
                + user
                    > user-master.blade.php         -> extends from components/app-master
                    > user-index.blade.php          -> extends from user-master
                    > user-read-all-posts.blade.php -> extends from user-master
                    > user-show-posts.blade.php     -> extends from user-master

                + contributor
                    > contributor-master.blade.php          -> extends from components/app-master
                    > contributor-index.blade.php           -> extends from contributor-master
                    > contributor-create-post.blade.php     -> extends from contributor-master
                    > contributor-posts-status.blade.php    -> extends from contributor-master
                    > contributor-preview-post.blade.php    -> extends from contributor-master
                    > contributor-read-all-posts.blade.php  -> extends from contributor-master
                    > contributor-read-my-posts.blade.php   -> extends from contributor-master
                    > contributor-show-post.blade.php       -> extends from contributor-master

                + moderator
                    > moderator-master.blade.php                -> extends from components/app-master
                    > moderator-index.blade.php                 -> extends from moderator-master
                    > moderator-add-contributors.blade.php      -> extends from moderator-master
                    > moderator-create-post.blade.php           -> extends from moderator-master
                    > moderator-edit-post-preview.blade.php     -> extends from moderator-master
                    > moderator-edit-post.blade.php             -> extends from moderator-master
                    > moderator-moderate-posts.blade.php        -> extends from moderator-master
                    > moderator-preview-post.blade.php          -> extends from moderator-master
                    > moderator-read-all-posts.blade.php        -> extends from moderator-master
                    > moderator-read-my-posts.blade.php         -> extends from moderator-master
                    > moderator-show-post.blade.php             -> extends from moderator-master
                    > moderator-index.blade.php                 -> extends from moderator-master
                    > moderator-index.blade.php                 -> extends from moderator-master
                    > moderator-index.blade.php                 -> extends from moderator-master


                    
                + admin
                    > admin-master.blade.php                -> extends from components/app-master
                    > admin-index.blade.php                 -> extends from admin-master
                    > admin-add-users.blade.php             -> extends from admin-master
                    > admin-create-post.blade.php           -> extends from admin-master
                    > admin-edit-post-preview.blade.php     -> extends from admin-master
                    > admin-edit-post.blade.php             -> extends from admin-master
                    > admin-moderate-posts.blade.php        -> extends from admin-master
                    > admin-preview-post.blade.php          -> extends from admin-master
                    > admin-read-all-posts.blade.php        -> extends from admin-master
                    > admin-read-my-posts.blade.php         -> extends from admin-master                   
                    > admin-show-post.blade.php             -> extends from admin-master
                    > admin/settings
                        < alias-names-tab
                            + alias-names.blade.php
                            + pair-user-alias.blade.php
                        < categories-tab
                            + categories.blade.php
                        < general-system-config-tab
                            + digest-email.blade.php
                            + num-posts-displayed.blade.php
                        < settings-js                               -> IGNORE THIS FOLDER
                        < toast-settings-tab
                            + toast-settings.blade.php
                        < admin-settings.blade.php                  -> extends from admin-master

                        
                + components
                    > app-base.blade.php -> (root view file)

                    > app-master.blade.php -> extends from (root view file)

                    > sessions.blade.php -> div that holds session data. 
                        ~ used for determining when toast msgs are to be displayed.

                    > inactive-user.blade.php -> the view that a user will be directed to after logging into SAML.
                        ~ If the user's role_id = 5, they will not be logged into the app and will not be able to use the app or any of the routes.

                    > logout.blade.php -> the view that a user will be directed to when they log out. 
                        ~ When user clicks 'logout' button, their session/$_SERVER data is deleted and they are no longer authorized by laravel. 
                        ~ They have to log in again with SAML.

                    > navbar-user-menu.blade.php -> HTML code for "User Menu" button in the gold-bar.
                        ~ Only displays when the window size is max-width: 999px.


        * MODEL (DATA) - app/ - Where all the files are that interact with data tables
            - Account.php
                + interacts with accounts table
            - Category.php
                + interacts with categories table
            - Post.php
                + interacts with posts table
            - Role.php
                + interacts with roles table
            - Topic.php
                + interacts with topics table
            - User.php 
                + interacts with users table

        * ROUTES - routes/web.php - Where all the routes are located
            - defines all the routes for requests to controllers and controller methods
            - 
                
    3. Important Files 
        * routes.php - app/routes/
            -
                +
                +
                +
                +
            -
            -
            -
        * Controllers - app/Http/Controllers

        * Middlewares - app/Http/Middleware
            - Kernel.php - app/Http/
        * 


    4. Moving from Dev to Production 
        * .env file
            -
                +
                +
                +
                +
            -
            -
            -
        *
        *
        *

    5. Users & Roles 
        * Admin
            - Controller
                +
                +
                +
                +
            - Views
                +
                +
                +
                +
            - JS files
                +
                +
                +
                +
            - 
        * Moderator
            - Controller
                +
                +
                +
                +
            - Views
                +
                +
                +
                +
            - JS files
                +
                +
                +
                +
            - 
        * Contributor
            - Controller
                +
                +
                +
                +
            - Views
                +
                +
                +
                +
            - JS files
                +
                +
                +
                +
            - 
        * User 
            - Controller
                +
                +
                +
                +
            - Views
                +
                +
                +
                +
            - JS files
                +
                +
                +
                +
            - 
 -->