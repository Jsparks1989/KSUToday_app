<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\Category;
use App\Topic;
use App\Account;
use App\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function __construct() {
        $this->middleware('isAdmin');
    }




    public function index() {
        return view('admin.admin-index');
    }


    // public function logout(){
    //     session()->flush();
    //     Auth::logout();
    //     return redirect()->intended('/');
    // }


    public function readPosts() {
        $posts = Post::where('post_state', 'Published')->orderBy('created_at', 'desc')->paginate(10)->appends(request()->all());
        $categories = Category::all();
        $accounts = Account::all();
        
        // foreach($posts as $post){
            //-- Re-format $post->updated_at to only mm/dd/yyyy
            // $post->created_at = date('d-m-Y', strtotime($post->created_at));
            // $date = date('m-d-Y', strtotime($post->created_at));
            
        // }
        
        return view('admin.admin-read-all-posts', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
        // dd($posts);
    }




    public function readPostSubmit() {
        $categories = Category::all();
        $accounts = Account::all(); 

        // Set order_by
        $arr['order_by'] = request('order_by');


        if($arr['order_by'] == 'newest'){
            $posts = Post::where('post_state', 'Published')
                ->when(request('title') != null, function($q){
                    return $q->where('title', request('title'));
                })
                ->when(request('accounts_select') != '0' && request('accounts_select') != 'netID', function($q){
                    $account_name = Account::findOrFail(request('accounts_select'))->name;
                    return $q->where('from_account', $account_name);
                })
                ->when(request('accounts_select') == 'netID', function($q){
                    return $q->where('from_account', request('netID'));
                })
                ->when(request('categories_select') != '0', function($q){
                    return $q->where('category_id', request('categories_select'));
                })
                ->when(request('topics_select') != '0', function($q){
                    return $q->where('topic_id', request('topics_select'));
                })
                ->orderBy('created_at', 'desc')->paginate(5)->appends(request()->all());

                if(count($posts) == 0){
                    $noPosts = 'No posts were found';
                    return view('admin.admin-read-all-posts', ['noPosts' => $noPosts, 'categories' => $categories, 'accounts' => $accounts]);
                } else {
                    return view('admin.admin-read-all-posts', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
                }
                
        } elseif($arr['order_by'] == 'oldest'){
            $posts = Post::where('post_state', 'Published')
                ->when(request('title') != null, function($q){
                    return $q->where('title', request('title'));
                })
                ->when(request('accounts_select') != '0' && request('accounts_select') != 'netID', function($q){
                    $account_name = Account::findOrFail(request('accounts_select'))->name;
                    return $q->where('from_account', $account_name);
                })
                ->when(request('accounts_select') == 'netID', function($q){
                    return $q->where('from_account', request('netID'));
                })
                ->when(request('categories_select') != '0', function($q){
                    return $q->where('category_id', request('categories_select'));
                })
                ->when(request('topics_select') != '0', function($q){
                    return $q->where('topic_id', request('topics_select'));
                })
                ->orderBy('created_at', 'asc')->paginate(5)->appends(request()->all());

                if(count($posts) == 0){
                    $noPosts = 'No posts were found';
                    return view('admin.admin-read-all-posts', ['noPosts' => $noPosts, 'categories' => $categories, 'accounts' => $accounts]);
                } else {
                    return view('admin.admin-read-all-posts', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
                }
        }


        

    }





    public function showPost(Post $post) {
        $file_name = str_replace("file_attach/", "", $post->file_attach);
        // $post->created_at = date('m-d-Y', strtotime($post->created_at));
        return view('admin.admin-show-post', ['post' => $post, 'file_name' => $file_name]);
    }


    public function createPost() {

        // get all post categories
        $categories = Category::all();

        // get all alias accounts
        // $accounts = Account::all();
        $accounts = User::findOrFail(Auth::user()->id)->accounts()->get();

        // get current user's netID for 'Post From Account: *'
        $netID = Auth::user()->name;

        // return create-post view
        return view('admin.admin-create-post', ['categories' => $categories, 'accounts' => $accounts, 'netID' => $netID]);
    }


    public function createPostPreview() {

        $inputs = request()->validate([
            'title' => 'required | min:1 | max:255',
            'category_id' => 'required',
            'from_account' => 'required',
            'summary' => 'required | min:1 | max:300',
            'full_message' => 'required | min:1',
            'image' => 'image | mimes:png,gif,jpg,jpeg | max:2048',
            'file_attach' => 'file | mimes:jpg,gif,png,txt,docx,doc,xlsx,xls,pdf,ppt,pps,odt,ods,odp,pptx,ppsx',
        ]);

        if(request('category_id')){
            $inputs['category_name'] = Category::findOrFail($inputs['category_id'])->name;
        }

        if(request('topic_id')){
            $inputs['topic_id'] = request('topic_id');
            $inputs['topic_name'] = Topic::findOrFail($inputs['topic_id'])->name;
        } else {
            $inputs['topic_id'] = 'none';
        }

        if(request('image')){
            $inputs['image'] = request('image')->store('images');
        } else {
            if(request('category_id') == 1){
                $inputs['image'] = 'images\v2uGVOVFsqovgLJgkpIXOJ4f5grmKWbEksiIsVHJ.png';
            } elseif(request('category_id') == 2){
                $inputs['image'] = 'images\oIi0avBTzKoVzqVew2L9kMsVGUPgKUCG23pfdeHO.png';
            } elseif(request('category_id') == 3){
                $inputs['image'] = 'images\8P10JkgzwS52h7vJIJMZxPImIed2xhf8qJPRTHmL.png';
            } elseif(request('category_id') == 4){
                $inputs['image'] = 'images\VT2lBve4jadNVOqCiFSTMYo8gTbyGnpNjMpn4Hcv.png';
            } elseif(request('category_id') == 5){
                $inputs['image'] = 'images\Bvs3ncLNre2mDupYwLHC1kAGd6oRqWv86HdO4z3e.png';
            } else {
                $inputs['image'] = 'images\IgQGlpz7Sw0Dwd9DVDgTHL2uZpJrt0oyn1SOdSOK.png';
            }
        }

        // dd(request('file_attach'));
        if(request('file_attach') != null){
            $inputs['file_attach'] = request('file_attach')->store('file_attach');
            $inputs['file_name'] = str_replace("file_attach/", "", $inputs['file_attach']);
        } else {
            $inputs['file_attach'] = 'Temporary file_attach ';
            $inputs['file_name'] = '';
        }

        $inputs['post_state'] = 'Needs Review';

        session(['draftPost' => $inputs]);

        return view('admin.admin-preview-post', ['inputs' => $inputs]);
        
    }


    public function storePreviewPost(Request $request) {
        $value = $request->session()->get('draftPost');


        $inputs['title'] = $value['title'];
        $inputs['category_id'] = $value['category_id'];
        if($value['topic_id'] == 'none'){
            $inputs['topic_id'] = 0;
        } else {
            $inputs['topic_id'] = $value['topic_id'];
        }
        $inputs['from_account'] = $value['from_account'];
        $inputs['summary'] = $value['summary'];
        $inputs['full_message'] = $value['full_message'];
        $inputs['image'] = $value['image'];
        $inputs['file_attach'] = $value['file_attach'];
        $inputs['post_state'] = $value['post_state'];

        $request->session()->forget('draftPost');
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $user->posts()->create($inputs);

        // Flash session data to let the user know that the post was successfully updated
        session()->flash('post-created-message', 'New post was saved');

        return redirect()->route('admin.read-posts');


    }



    public function storePost() {

        $inputs = request()->validate([
            'title' => 'required | min:1 | max:255',
            'category_id' => 'required',
            'from_account' => 'required',
            'summary' => 'required | min:1 | max:300',
            'full_message' => 'required | min:1',
            'image' => 'image | mimes:png,gif,jpg,jpeg | max:2048',
            'file_attach' => 'file | mimes:jpg,gif,png,txt,docx,doc,xlsx,xls,pdf,ppt,pps,odt,ods,odp,pptx,ppsx',
        ]);

        if(request('topic_id')){
            $inputs['topic_id'] = request('topic_id');
        } else {
            $inputs['topic_id'] = 0;
        }

        if(request('image')){
            $inputs['image'] = request('image')->store('images');
        } else {
            if(request('category_id') == 1){
                $inputs['image'] = 'images\v2uGVOVFsqovgLJgkpIXOJ4f5grmKWbEksiIsVHJ.png';
            } elseif(request('category_id') == 2){
                $inputs['image'] = 'images\oIi0avBTzKoVzqVew2L9kMsVGUPgKUCG23pfdeHO.png';
            } elseif(request('category_id') == 3){
                $inputs['image'] = 'images\8P10JkgzwS52h7vJIJMZxPImIed2xhf8qJPRTHmL.png';
            } elseif(request('category_id') == 4){
                $inputs['image'] = 'images\VT2lBve4jadNVOqCiFSTMYo8gTbyGnpNjMpn4Hcv.png';
            } elseif(request('category_id') == 5){
                $inputs['image'] = 'images\Bvs3ncLNre2mDupYwLHC1kAGd6oRqWv86HdO4z3e.png';
            } else {
                $inputs['image'] = 'images\IgQGlpz7Sw0Dwd9DVDgTHL2uZpJrt0oyn1SOdSOK.png';
            }
        }

        if(request('file_attach')){
            $inputs['file_attach'] = request('file_attach')->store('file_attach');
        } else {
            $inputs['file_attach'] = 'Temporary file_attach';
        }

        $inputs['post_state'] = 'Needs Review';

        // dd($inputs);
        // Flash session data to let the user know that the post was successfully updated
        session()->flash('post-created-message', 'New post was saved');
        
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $user->posts()->create($inputs);

        return redirect()->route('create-post');
    }


    public function updatePost(Post $post) {
        $inputs = request()->validate([
            'title' => 'required | min:1 | max:255',
            'category_id' => 'required',
            'from_account' => 'required',
            'summary' => 'required | min:1 | max:300',
            'full_message' => 'required | min:1',
            'image' => 'image | mimes:png,gif,jpg,jpeg | max:2048',
            'file_attach' => 'file | mimes:jpg,gif,png,txt,docx,doc,xlsx,xls,pdf,ppt,pps,odt,ods,odp,pptx,ppsx',
        ]);

        if(request('topic_id')){
            $inputs['topic_id'] = request('topic_id');
        } else {
            $inputs['topic_id'] = 0;
        }

        if(request('image')){
            $inputs['image'] = request('image')->store('images');
        } else {
            $inputs['image'] = $post->image;
        }

        if(request('file_attach')){
            $inputs['file_attach'] = request('file_attach')->store('file_attach');
        } else {
            $inputs['file_attach'] = $post->file_attach;
        }

        $inputs['post_state'] = $post->post_state;

        $post->title = $inputs['title'];
        $post->category_id = $inputs['category_id'];
        $post->topic_id = $inputs['topic_id'];
        $post->from_account = $inputs['from_account'];
        $post->summary = $inputs['summary'];
        $post->full_message = $inputs['full_message'];
        $post->image = $inputs['image'];
        $post->file_attach = $inputs['file_attach'];
        $post->post_state = $inputs['post_state'];

        $user = User::findOrFail($post->user_id);
 
        $user->posts()->save($post);

        // Flash session data to let the user know that the post was successfully updated
        session()->flash('post-updated-message', 'Post was updated');

        return redirect()->route('moderate-posts');
    }



    public function readMyPosts() {
        // Set current user
        $user = Auth::user()->id;
        // Get posts where user_id = $user
        // $posts = Post::where('post_state', 'Published')->where('user_id', $user)->orderBy('created_at', 'desc')->paginate(10)->appends(request()->all());
        $posts = Post::where('user_id', $user)->orderBy('created_at', 'desc')->paginate(10)->appends(request()->all());
        
        

        if(count($posts) == 0){
            $noPosts = 'No posts were found';
            return view('admin.admin-read-my-posts', ['noPosts' => $noPosts]);
        } else {
            // foreach($posts as $post){
                //-- Re-format $post->updated_at to only mm/dd/yyyy
                // $post->created_at = date('d-m-Y', strtotime($post->created_at));
                // $date = date('m-d-Y', strtotime($post->created_at));
            // }
            return view('admin.admin-read-my-posts', ['posts' => $posts]);
        }
    }

    public function editPost(Post $post) {
        $netID = User::findOrFail($post->user_id)->name;
        $categories = Category::all();
        $topics = Topic::all();
        // $accounts = Account::all();
        $accounts = User::findOrFail(Auth::user()->id)->accounts()->get();
        $file_name = str_replace("file_attach/", "", $post->file_attach);

        session(['post' => $post]);


        return view('admin.admin-edit-posts', ['post' => $post, 'categories' => $categories, 'topics' => $topics, 'netID' => $netID, 'accounts' => $accounts, 'file_name' => $file_name]);
    }



    public function editPostPreview(Post $post) {

        $inputs = request()->validate([
            'title' => 'required | min:1 | max:255',
            'category_id' => 'required',
            'from_account' => 'required',
            'summary' => 'required | min:1 | max:300',
            'full_message' => 'required | min:1',
            'image' => 'image | mimes:png,gif,jpg,jpeg | max:2048',
            'file_attach' => 'file | mimes:jpg,gif,png,txt,docx,doc,xlsx,xls,pdf,ppt,pps,odt,ods,odp,pptx,ppsx',
        ]);

        if(request('category_id')){
            $inputs['category_name'] = Category::findOrFail($inputs['category_id'])->name;
        }

        if(request('topic_id')){
            $inputs['topic_id'] = request('topic_id');
            $inputs['topic_name'] = Topic::findOrFail($inputs['topic_id'])->name;
        } else {
            $inputs['topic_id'] = 'none';
        }

        if(request('image')){
            $inputs['image'] = request('image')->store('images');
        } else {
            $inputs['image'] = $post->image;
        }

        if(request('file_attach')){
            $inputs['file_attach'] = request('file_attach')->store('file_attach');
            $inputs['file_name'] = str_replace("file_attach/", "", $inputs['file_attach']);
        } else {
            $inputs['file_attach'] = $post->file_attach;
            $inputs['file_name'] = str_replace("file_attach/", "", $inputs['file_attach']);
        }

        $inputs['post_state'] = $post->post_state;

        $inputs['user_id'] = $post->user_id;

        // dd($inputs);

        session(['draftPost' => $inputs]);

        return view('admin.admin-edit-post-preview', ['inputs' => $inputs, 'post' => $post]);
        
    }


    public function updatePreviewPost(Post $post, Request $request) {
        $value = $request->session()->get('draftPost');

        $post->title = $value['title'];
        $post->category_id = $value['category_id'];
        if($value['topic_id'] == 'none'){
            $post->topic_id = 0;
        } else {
            $post->topic_id = $value['topic_id'];
        }
        $post->from_account = $value['from_account'];
        $post->summary = $value['summary'];
        $post->full_message = $value['full_message'];
        $post->image = $value['image'];
        $post->file_attach = $value['file_attach'];
        $post->post_state = $value['post_state'];

        $request->session()->forget('draftPost');

        $user = User::findOrFail($post->user_id);
        $user->posts()->save($post);

        // Flash session data to let the user know that the post was successfully updated
        session()->flash('post-updated-message', 'Post was updated');

        return redirect()->route('admin.moderate-posts');

        // dd($post);

    }


    public function searchUserSubmit() {
        $roles = Role::where('id', '!=', 1)->get();

        $users = User::where('role_id', '!=', 1)
            ->when(request('search_roles_select') == 'All', function($q){
                return $q->where('role_id', '!=', 'null');
            })
            ->when(request('search_roles_select') != 'All' && request('search_roles_select') != 'netID', function($q){
                return $q->where('role_id', request('search_roles_select'));
            })
            ->when(request('search_roles_select') == 'netID', function($q){
                return $q->where('name', request('netID'));
            })
            ->orderBy('created_at', 'asc')->paginate(15)->appends(request()->all());
            
        if(count($users) == 0){
            $noUsers = 'No Users were found';
            return view('admin.admin-add-users', ['roles' => $roles, 'noUsers' => $noUsers]);
        } else {
            return view('admin.admin-add-users', ['roles' => $roles, 'users' => $users]);
        }
    }



    public function moderateUsers() {
        $roles = Role::get();
        $users = User::where('id', '!=', 1)->paginate(20)->appends(request()->all());
        return view('admin.admin-add-users', ['roles' => $roles, 'users' => $users]);
    }



    public function removeUser() {
        //-- Two options for removing Users: --//

        // 1. update the user with a new role_id = 0 | This will keep the user in the ksut users table
        // ===========================================================================================

        // session()->flash('user-removed-message', 'User has been removed');
        
        // $user = User::findOrFail(request('user_id'));
        // $user->role_id = 1;
        // $user->save();

        // return redirect()->route('admin.add-users');


        // 2. remove the user entirely from users table | This will completely remove the user from the ksut users table
        // =============================================================================================================

        session()->flash('user-removed-message', 'User has been removed');

        User::destroy(request('user_id'));

        return redirect()->route('admin.moderate-users');
    }



    public function storeNewUser() {
        $inputs = request()->validate([
            'netID' => 'required | min:8 | max:100',
            'email' => 'required | min:8 | max:100',
            'password' => 'required | min:8 | max:100',
        ]);

        // setting the role to contributor
        $inputs['role_id'] = request('roles_select_new');

        // setting the flash session message
        if($inputs['role_id'] == 2){
            session()->flash('user-created-message', 'New contributor was added');
        } elseif($inputs['role_id'] == 3){
            session()->flash('user-created-message', 'New moderator was added');
        } elseif($inputs['role_id'] == 4){
            session()->flash('user-created-message', 'New administrator was added');
        }


        $user = new User;
        $user->role_id = $inputs['role_id'];
        $user->name = $inputs['netID'];
        $user->email = $inputs['email'];
        $user->password = Hash::make($inputs['password']);
        $user->save();

        return redirect()->route('moderate-users');
    }
    

    public function updateUser() {
        $user = User::findOrFail(request('user_id'));
        $user->role_id = request('roles_select');
        $user->save();

        // setting the flash session message
        if(request('roles_select') == 2){
            session()->flash('user-updated-message', 'User\'s role was updated to contributor');
        } elseif(request('roles_select') == 3){
            session()->flash('user-updated-message', 'User\'s role was updated to moderator');
        } elseif(request('roles_select') == 4){
            session()->flash('user-updated-message', 'User\'s role was updated to administrator');
        }
        return redirect()->route('admin.moderate-users');
    }



    public function moderatePosts() {
        $posts = Post::orderBy('created_at', 'desc')->paginate(20)->appends(request()->all());
        $categories = Category::all();
        $accounts = Account::all();
        // $users = User::where('role_id', '!=', 1)->get();

        // foreach($posts as $post){
            //-- Re-format $post->updated_at to only mm/dd/yyyy
            // $post->created_at = date('d-m-Y', strtotime($post->created_at));
            // $date = date('m-d-Y', strtotime($post->created_at));
        // }
        return view('admin.admin-moderate-posts',['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
        // return view('moderator.moderator-moderate-posts',['posts' => $posts]);
    }


    public function moderatePostsSubmit() {
        $categories = Category::all();
        $accounts = Account::all(); 

        $posts = Post::query()
                ->when(request('title') != null, function($q){
                    return $q->where('title', request('title'));
                })
                ->when(request('accounts_select') != '0' && request('accounts_select') != 'netID', function($q){
                    $account_name = Account::findOrFail(request('accounts_select'))->name;
                    return $q->where('from_account', $account_name);
                })
                ->when(request('accounts_select') == 'netID', function($q){
                    return $q->where('from_account', request('netID'));
                })
                ->when(request('categories_select') != '0', function($q){
                    return $q->where('category_id', request('categories_select'));
                })
                ->when(request('topics_select') != '0', function($q){
                    return $q->where('topic_id', request('topics_select'));
                })
                ->when(request('state_select') == 'Needs Review', function($q){
                    return $q->where('post_state', request('state_select'));
                })
                ->when(request('state_select') == 'Publish', function($q){
                    return $q->where('post_state', request('state_select'));
                })
                ->when(request('state_select') == 'Published', function($q){
                    return $q->where('post_state', request('state_select'));
                })
                ->orderBy('created_at', 'desc')->paginate(15)->appends(request()->all());


                if(count($posts) == 0){
                    $noPosts = 'No posts were found';
                    return view('admin.admin-moderate-posts', ['noPosts' => $noPosts, 'categories' => $categories, 'accounts' => $accounts]);
                } else {
                    return view('admin.admin-moderate-posts',['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
                }
        
    }

    public function adminSettings() {
        $categories = Category::all();
        $topics = Topic::all();
        return view('admin.settings.admin-settings',['categories' => $categories, 'topics' => $topics]);
    }
    
}
