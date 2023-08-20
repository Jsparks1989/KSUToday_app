<!-- ====================================================================================================== 
 * Moderator add contributors view   
 
 * URL - APP_URL/moderate-contributors

 * CHILD VIEW of - moderator.moderator-master      
 
 * What page is doing:
    - shows all users that are contributors
    - can create a new contributor
    - can search contributors

 * Controller 
    - PageController@moderateContributors -> ModeratorController@moderateContributors()
        > route - /moderate-contributors

    - AjaxController@liveSearchContributors() populate tbody & search contributors 
        > route - /live-search-contributors

    - AjaxController@addContributor() when new contributor is added
        > route - /add-contributor

 * JS file 
    - app/public/js/moderator/mod-add-conributors.js
    - app/public/js/root.js
    - app/public/js/toastr.js
    - app/public/js/toast-messages.js

 * CSS file
    - 
 ====================================================================================================== -->




@extends('moderator.moderator-master')


<!-- yield from moderator-master.blade.php -->
@section('moderator-js-scripts')
    <script src="{{asset('js/moderator/mod-add-contributor.js')}}"></script>
@endsection


<!-- yield from moderator-master.blade.php -->
@section('moderator-css-styles')

@endsection

<!-- yield from component.app-base -->
@section('main')

    @include('components.sessions')

    <h1>Moderate Contributors</h1>

    <div class="container-box">
        <label for="title_summary">Search Contributors:</label>
        <input type="text" name="contributors_search" class="search_my_posts" id="contributors_search" placeholder="Search by netID" />
    </div>

    <br>

    <button class="btn search-btn" id="open_add_contrib_modal">Add Contributor</button>
    
    <br>



    <div id="dynamic_content">

        <table class="table">

            <thead>
                <tr>
                    <th>netID</th>
                    <th>Added At</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>netID</th>
                    <th>Added At</th>
                </tr>
            </tfoot>

            <tbody id="contributor_list">    
            </tbody>

        </table>
        <br />
        <div id="pagination"></div>
    </div>

    
    <!-- Add Contributor Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h3>Add a Contributor:</h3>
            <input type="email" name="new_contrib_email" class="" id="new_contrib_email" placeholder="Enter Email" />
            <p class="add-contrib-error" id="not_ksu_email_error" style="color:red; display:none;">Please enter a KSU faculty/staff email address</p>
            <p class="add-contrib-error" id="not_users_email_error" style="color:red; display:none;">Cannot use your own email address</p>
            <p class="add-contrib-error" id="not_admins_email_error" style="color:red; display:none;">Cannot use an Administrator's nor a Moderator's email</p>

            <button type="submit" class="btn search-btn" id="add_contributor" name="add_contributor">Submit</button>
        </div>

    </div>

  
@endsection