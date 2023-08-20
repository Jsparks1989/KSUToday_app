<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Account;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function __construct() {
        $this->middleware('isUser');
    }


    public function index(){
        return view('user.user-index');
    }

    // public function logout(){
    //     session()->flush();
    //     Auth::logout();
    //     return redirect()->intended('/');
    // }

    // Read All Posts
    public function readPosts() {
        $posts = Post::where('post_state', 'Published')->orderBy('created_at', 'desc')->paginate(10)->appends(request()->all());
        $categories = Category::all();
        $accounts = Account::all();
        
        // foreach($posts as $post){
            //-- Re-format $post->updated_at to only mm/dd/yyyy
            // $post->updated_at = date('d/m/Yyyy', strtotime($post->updated_at));
            // $post->updated_at = strtotime($post->updated_at);
            // $date = date('m-d-Y', strtotime($post->created_at));
            // $newDate = substr($post->updated_at, 0, strpos($post->updated_at, " "));
        // }
        
        return view('user.user-read-all-posts', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
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
                    return view('user.user-read-all-posts', ['noPosts' => $noPosts, 'categories' => $categories, 'accounts' => $accounts]);
                } else {
                    return view('user.user-read-all-posts', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
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
                    return view('user.user-read-all-posts', ['noPosts' => $noPosts, 'categories' => $categories, 'accounts' => $accounts]);
                } else {
                    return view('user.user-read-all-posts', ['posts' => $posts, 'categories' => $categories, 'accounts' => $accounts]);
                }
        }

    }


 
    /**
     * 
     * Show One Specific Post when click 'read more -->' from read-all-posts
     * =====================================================================
     * 
     * Use Route-Model Binding to show single post
     * ===========================================
     * Since I am passing in Post class as a param, laravel knows
     * to look for the specific post's id in the view.
     * The link tag that routes to show the whole post has that post's
     * id passed in as a param.
     * 
     * This allows all the data on that specific post to be passed to the 
     * user-show-post view.
     */ 
    public function showPost(Post $post) {
        $file_name = str_replace("file_attach/", "", $post->file_attach);
        // $post->created_at = date('m-d-Y', strtotime($post->created_at));
        return view('user.user-show-post', ['post' => $post, 'file_name' => $file_name]);
    }


}






