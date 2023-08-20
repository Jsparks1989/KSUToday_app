<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Category;
use App\Topic;
use App\Account;
use Illuminate\Support\Facades\Auth;

class ContributorController extends Controller
{
    //
    public function __construct() {
        $this->middleware('isContributor');
    }

    public function index() {
        return view('contributor.contributor-index');
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
        
        return view('contributor.contributor-read-all-posts', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
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
                    return view('contributor.contributor-read-all-posts', ['noPosts' => $noPosts, 'categories' => $categories, 'accounts' => $accounts]);
                } else {
                    // foreach($posts as $post){
                        //-- Re-format $post->updated_at to only mm/dd/yyyy
                        // $post->created_at = date('d-m-Y', strtotime($post->created_at));
                        // $date = date('m-d-Y', strtotime($post->created_at));
                    // }
                    return view('contributor.contributor-read-all-posts', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
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
                    return view('contributor.contributor-read-all-posts', ['noPosts' => $noPosts, 'categories' => $categories, 'accounts' => $accounts]);
                } else {
                    // foreach($posts as $post){
                        //-- Re-format $post->updated_at to only mm/dd/yyyy
                        // $post->created_at = date('d-m-Y', strtotime($post->created_at));
                        // $date = date('m-d-Y', strtotime($post->created_at));
                    // }
                    return view('contributor.contributor-read-all-posts', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
                }
        }
    }

    


    public function showPost(Post $post) {
        // $date = date('m-d-Y', strtotime($post->created_at));
        $file_name = str_replace("file_attach/", "", $post->file_attach);
        // return view('contributor.contributor-show-post', ['post' => $post, 'file_name' => $file_name, 'date' => $date]);
        return view('contributor.contributor-show-post', ['post' => $post, 'file_name' => $file_name]);
    }


    public function readMyPosts() {

        // Set current user
        $user = Auth::user()->id;
        
        // Get posts where user_id = $user
        // $posts = Post::where('post_state', 'Published')->where('user_id', $user)->orderBy('created_at', 'desc')->paginate(10)->appends(request()->all());
        $posts = Post::where('user_id', $user)->orderBy('created_at', 'desc')->paginate(10)->appends(request()->all());
        

        // if no posts were found...
        if(count($posts) == 0){
            $noPosts = 'No posts were found';
            return view('contributor.contributor-read-my-posts',['noPosts' => $noPosts]);
        } else {
            // foreach($posts as $post){
                //-- Re-format $post->updated_at to only mm/dd/yyyy
                // $post->updated_at = date('d-m-Y', strtotime($post->updated_at));
                // $date = date('m-d-Y', strtotime($post->created_at));
            // }
            return view('contributor.contributor-read-my-posts', ['posts' => $posts]);
        }

        
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
        return view('contributor.contributor-create-post', ['categories' => $categories, 'accounts' => $accounts, 'netID' => $netID]);
    }


    public function postPreview() {

        $inputs = request()->validate([
            'title' => 'required | min:1 | max:255',
            'category_id' => 'required',
            'from_account' => 'required',
            'summary' => 'required | min:1 | max:300',
            'full_message' => 'required | min:1',
            'image' => 'image | mimes:png,gif,jpg,jpeg | max:2048',
            'file_attach' => 'file | mimes:txt,docx,doc,xlsx,xls,pdf,ppt,pps,odt,ods,odp,pptx,ppsx',
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

        if(request('file_attach')){
            $inputs['file_attach'] = request('file_attach')->store('file_attach');
            $inputs['file_name'] = str_replace("file_attach/", "", $inputs['file_attach']);
        } else {
            $inputs['file_attach'] = 'Temporary file_attach';
        }

        $inputs['post_status'] = 'Needs Review';

        session(['draftPost' => $inputs]);

        return view('contributor.contributor-preview-post', ['inputs' => $inputs]);
        
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
        $inputs['post_state'] = "Needs Review";

        $request->session()->forget('draftPost');
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $user->posts()->create($inputs);

        session()->flash('post-created-message', 'Post was created');

        return redirect()->route('create-post');


    }


    /**
     * posts columns that need to be filled:
     *  - user_id        - filled by IDing the currently authorized user. Using posts() method from User model. 
     *  - title*         - <input name='title'>
     *  - category_id*   - <input name='category_id'> - 
     *  - topic_id       - <input name='topic_id'>
     *  - from_account*  - <option name='from_account'>
     *  - summary*       - <textarea name='summary'>
     *  - full_message*  - <textarea name='full_message'>
     *  - image          - <input name='image'>
     *  - file_attach    - <input name='file_attach'>
     *  - post_state*    - <input name='post_state'>
     *  - state*         - set to 0(false) by default 
     */
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
            // $inputs['file_attach'] = null;
        }
        
        $inputs['post_state'] = "Needs Review";
        
        
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $user->posts()->create($inputs);

        session()->flash('post-created-message', 'Post was created');

        return redirect()->route('create-post');
    }


    public function postsStatus() {
        $posts = Post::where('post_state', '!=', 'Published')->orderBy('created_at', 'desc')->paginate(15)->appends(request()->all());
        $categories = Category::all();
        $accounts = Account::all();
        $users = User::where('role_id', '!=', 1)->get();

        // foreach($posts as $post){
            // $date = strtotime($post->updated_at);
            // $post->updated_at = date('m/d/Y', $date);
        // }
        return view('contributor.contributor-posts-status',['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts, 'users' => $users]);
    }


    public function postsStatusSubmit() {
        $categories = Category::all();
        $accounts = Account::all(); 

        // Set order_by
        $arr['order_by'] = request('order_by');


        if($arr['order_by'] == 'newest'){
            $posts = Post::where('post_state', '!=', 'Published')
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
                ->orderBy('created_at', 'desc')->paginate(15)->appends(request()->all());

                if(count($posts) == 0){
                    $noPosts = 'No posts were found';
                    return view('contributor.contributor-posts-status', ['noPosts' => $noPosts, 'categories' => $categories, 'accounts' => $accounts]);
                } else {
                    return view('contributor.contributor-posts-status', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
                }
                
        } elseif($arr['order_by'] == 'oldest'){
            $posts = Post::where('post_state', '!=', 'Published')
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
                ->orderBy('created_at', 'asc')->paginate(15)->appends(request()->all());

                if(count($posts) == 0){
                    $noPosts = 'No posts were found';
                    return view('contributor.contributor-posts-status', ['noPosts' => $noPosts, 'categories' => $categories, 'accounts' => $accounts]);
                } else {
                    return view('contributor.contributor-posts-status', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
                }
        }
    }

}
