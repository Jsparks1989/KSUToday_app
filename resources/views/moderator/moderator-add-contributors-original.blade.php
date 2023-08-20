@extends('moderator.moderator-master')


@section('css-styles')
    <!-- <link href="{{asset('css/success.css')}}" rel="stylesheet">
    <link href="{{asset('css/errors.css')}}" rel="stylesheet">
    <link href="{{asset('css/modal_delete.css')}}" rel="stylesheet"> -->
@endsection

@section('js-scripts')
    <!-- <script src="{{asset('js/modal_delete.js')}}"></script> -->
@endsection


@section('main')


<script>
    $(document).ready(function(){


        /**
         * =============================================================================== 
         * Displaying NetID input option
         * ===============================================================================
         */

        
        // When option <- search by netID -> is chosen
        $('select[name="contributors_select"]').click(function(){
            console.log($(this).val());
            $('#netID_section').show();
            if($(this).val() != 'netID'){
                $('#netID_section').hide();
            }
        }); 

    });
</script>


    <h1>Moderate Contributors</h1>

    <div>
        @if(session('contributor-created-message'))
            <div><h4 class="success">{{ session('contributor-created-message') }}</h4></div>

        @elseif(session('contributor-removed-message'))
            <div><h4 class="success">{{ session('contributor-removed-message') }}</h4></div>

        @endif
    </div>






        <!-- This is the "Add Contributor" form. Use this for the modal window -->
        <form action="{{route('store-new-contributors')}}" method="POST" enctype="multipart/form-data">
            <!-- csrf is a directive - laravels way of not allowing others on another server submit data through the form. -->
            @csrf
            <h3>Add a Contributor</h3>
            <!-- Contributor's netID -->
            <!-- <div class=""> -->
                <!-- <div> -->
                    <label for="netID">Contributor's netID: <span class="form_required">*</span></label>
                <!-- </div> -->
                <input type="text" 
                    name="netID" 
                    id="netID"
                    class="" 
                    placeholder="Enter netID">
                @error('netID')
                    <h4 class="error">{{ $message }}</h4>
                @enderror
            <!-- </div> -->
            <br>


            <!-- Wont need email or password for final version. When user signs in using the Login System, will compare user's netID to the users table -->
            <!-- Only doing email and password here so app will work on local machine -->
            <!-- Final version should only need netID and role_id to link netID to proper role. -->


            <!-- Contributor's email -->
            <!-- <div class=""> -->
                <!-- <div> -->
                    <label for="netID">Contributor's Email: *</label>
                <!-- </div> -->
                <input type="email" 
                    name="email" 
                    id="email"
                    class="" 
                    placeholder="Enter Email">
                @error('email')
                    <h4 class="error">{{ $message }}</h4>
                @enderror
            <!-- </div> -->
            <br>

        

            <!-- Contributor's password -->
            <div class="">
                <div>
                    <label for="password">Contributor's Password: *</label>
                </div>
                <input type="password" 
                    name="password" 
                    id="password"
                    class="" 
                    placeholder="Enter Password">
                @error('password')
                    <div><h4 class="error">{{ $message }}</h4></div>
                @enderror
            </div>
            <br>

            <button type="submit" class="btn search-btn" name="add_contributors">Add Contributor</button>

        </form>


    
        <!-- This is the "Search Contributors" Form -->
        <form action="{{route('search-contributors')}}" method="POST" enctype="multipart/form-data">
            <!-- csrf is a directive - laravels way of not allowing others on another server submit data through the form. -->
            @csrf
            <h3>Search for a Contributor</h3>
            
            <div>
                <label for="contributors_select">Search:</label>
                <select name="contributors_select" id="contributors_select">
                        <option name="contributors_option" value="All" selected>- All Contributors -</option>  
                        <option name="contributors_option" value="netID">- By netID -</option>
                </select>
            </div><br>
            

            <div id="netID_section" hidden>
                <label for="netID">netIDs:</label>
                <input type="text" name="netID"></input>
            </div><br>
            

            <button type="submit" class="btn search-btn" name="search_contributors">Search</button>
        </form>

        <table class="table">

            <thead>
                <tr>
                    <th>netID</th>
                    <th>Added At</th>
                    <!-- <th>Edit</th> -->
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>netID</th>
                    <th>Added At</th>
                    <!-- <th>Edit</th> -->
                </tr>
            </tfoot>

            <tbody>
                @if(isset($contributors))
                    @foreach($contributors as $contributor)
                        <tr>
                            <td>{{$contributor->name}}</td>
                            <td>{{$contributor->created_at}}</td>
                            {{--<td><button onclick="modalDelete('{{$contributor->id}}')" value="{{$contributor->id}}" class="myDeleteBtn">Remove Contributor</button></td>--}}
                        </tr>
                    @endforeach
                @endif

                @if(isset($noContributors))
                    <h2>{{ $noContributors }}</h2>
                @endif
            </tbody>
        </table>


    {{--
        <!-- The Modal -->
        <div id="modal_delete" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="deleteClose">&times;</span>
                <p>Are you sure you want to delete this contributor?</p>
                <form action="{{route('moderator.remove-contributors')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="modal_delete_user_id" name="user_id" style="display:none;">
                    <button type="submit">Remove</button>
                </form>
                
                <button class="deleteClose" id="modal_cancel_button">Cancel</button>
            </div>
        </div>
    --}}    
@endsection