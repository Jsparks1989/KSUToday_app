<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Post;
use App\Role;
use App\Category;
use App\User;
use App\Account;
use App\Toast;
use App\Position;
use App\Message;
use App\DigestEmail;
use App\CronJobDigest;
use App\DisplayPost;
use DB;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class AjaxController extends Controller
{

    /*
    
        $this->page_length - sets the length of pages returned from searching for 
                             users, posts, etc. 

        Methods where the length would be set: 
            liveSearchReadPosts()
            liveSearchUsers()
            liveSearchMyPosts()
            liveSearchContribPostsStatus()
            liveSearchModPostsStatus()
            liveSearchAdminPostsStatus()
            liveSearchContributors()
        
        Table -> display_posts
        column -> number_displayed

    
    */

    // protected $page_length;

    public function __construct() {
        $this->page_length = DisplayPost::pluck('number_displayed')->first();
    }

    /**
     * ============================================================================
     * Get Topics associated with Category
     * ============================================================================
     */
        public function getTopics($id) {
            if($id > 0){
                $arr['topics'] = Topic::where('category_id', $id)->get();
            }
            echo json_encode($arr);
        }

    /**
     * ============================================================================
     * Get All Posts by Newest to Oldest
     * ============================================================================
     */
        public function getNewestPosts() {
            $arr['posts'] = Post::orderBy('created_at', 'desc')->get();

            foreach($arr['posts'] as $post){
                if($post->updated_at){
                    // $formatDate = date('F-j-Y', strtotime($post->updated_at));
                    $formatDate = date('m-d-Y',strtotime($post->updated_at));
                    $post['formatted_date'] = $formatDate;
                }

                if($post->category_id){
                    $post['category'] = $post->category->name;
                }
            }

            echo json_encode($arr);
        }



    /**
     * ============================================================================
     * Get All Posts by Oldest to Newest
     * ============================================================================
     */
        public function getOldestPosts() {
            $arr['posts'] = Post::orderBy('created_at', 'asc')->get();

            foreach($arr['posts'] as $post){
                if($post->updated_at){
                    // $formatDate = date('F-j-Y', strtotime($post->updated_at));
                    $formatDate = date('m-d-Y',strtotime($post->updated_at));
                    $formatDate = 
                    $post['formatted_date'] = $formatDate;
                }

                if($post->category_id){
                    $post['category'] = $post->category->name;
                }

                if($post->topic_id){
                    $post['topic'] = Topic::where('id', $post->topic_id);
                }

            }

            echo json_encode($arr);
        }


    /**
     * ============================================================================
     * Get a Category
     * ============================================================================
     */
        public function getCategory($id) {
            $query = Category::findOrFail($id);
            $output = '';
            $total_row = $query->count();
                if($total_row > 0) {
                    foreach($query as $row) {
                        $output = $query;
                    }
                } else {
                    $output = 'No Category';
                }

            $data = array(
                // 'categories' => $query,
                // 'total rows' => $total_row,
                'output' => $output,
            );
            echo json_encode($data);
        }


    /**
     * ============================================================================
     * Update a Category
     * ============================================================================
     */
        public function editCategory($id, $value) {
            $query = Category::findOrFail($id);
            $query->name = $value;
            $query->save();

            $data = array(
                'cat_id' => $id,
                'value' => $value,
                'output' => 'category updated',
                'settings_route' => route('settings'),
            );
            echo json_encode($data);
        }


    /**
     * ============================================================================
     * Get All Categories
     * ============================================================================
     */
        public function getCategories() {
            $query = Category::get();
            $output = '';
            $category_names = [];

            foreach($query as $category) {
                array_push($category_names, $category->name);
            }

            $total_row = $query->count();
                if($total_row > 0) {
                    foreach($query as $row) {
                        $output .= '
                        <tr>
                            <td style="text-align:center">'.$row->name.'</td>
                        </tr>
                        ';
                    }
                } else {
                    $output = '
                    <tr>
                        <td align="center" colspan="5">No Categories Found</td>
                    </tr>
                    ';
                }

            $data = array(
                'categories' => $query,
                'total rows' => $total_row,
                'output' => $output,
                'category_names' => $category_names,
            );
            echo json_encode($data);
        }



    /**
     * ============================================================================
     * Get All Categories to Edit
     * ============================================================================
     */
        public function getCategoriesEdit() {
            $query = Category::get();
            $output = '';
            $category_names = [];
            $total_row = $query->count();

            foreach($query as $category) {
                array_push($category_names, $category->name);
            }

                if($total_row > 0) {
                    foreach($query as $row) {
                        $output .= '
                        <tr>
                            <td id="category_'.$row->id.'" class="categories" style="text-align:center">'.$row->name.'</td>
                        </tr>
                        ';
                    }
                } else {
                    $output = '
                    <tr>
                        <td align="center" colspan="5">No Categories Found</td>
                    </tr>
                    ';
                }

            $data = array(
                'categories' => $query,
                'total_rows' => $total_row,
                'output' => $output,
                'category_names' => $category_names,
            );
            echo json_encode($data);
        }



    /**
     * ============================================================================
     * Admin->Moderate Users
     * ============================================================================
     */
        public function addCategory(Request $request) {
            if($request->ajax()) {
                $output = '';
                $query = $request->get('query');


                // $query_user = User::where('email', $query['email'])->first();
                // dd($query);

                // if($query_user) {
                    // session()->flash('user-exists-message', 'The user already exists.');
                    // $the_user = 'the user exists';
                // } else {
                    // $the_user = 'the user has been created';

                    $category = new Category;
                    $category->name = $query;
                    $category->save();

                    // session()->flash('user-created-message', 'New category has been added!');
                // }


                $data = array(
                    'query' => $query,
                    'settings_route' => route('settings'),
                );

                echo json_encode($data);
            }
        }



    /**
     * ============================================================================
     * Get Accounts
     * ============================================================================
     */
    public function getAccounts() {
        $query = Account::get();
        $output = '';
        $user_pair_alias = '';

        $alias_names = [];

        foreach($query as $alias) {
            array_push($alias_names, $alias->name);
        }


        $total_row = $query->count();
            if($total_row > 0) {
                foreach($query as $row) {
                    $output .= '
                    <tr>
                        <td style="text-align:center">'.$row->name.'</td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Accounts Found</td>
                </tr>
                ';
            }


            if($total_row > 0) {
                foreach($query as $row) {
                    $user_pair_alias .= '<p class="account_draggable" id="'.$row->id.'">'.$row->name.'<span style="font-weight:bold; padding: 10px"> &times;</span></p>';
                }
            } else {
                $user_pair_alias = 'No Accounts Found';
            }

            // $users_accounts = User::findOrFail(14)->accounts()->get();

        $data = array(
            'accounts' => $query,
            'total rows' => $total_row,
            'output' => $output,
            'alias_names' => $alias_names,
            'user_pair_alias' => $user_pair_alias,
            // 'users_accounts' => $users_accounts,
        );
        echo json_encode($data);
    }


    


    


    



    



    /**
     * ============================================================================
     * Get User
     * ============================================================================
     */
    public function getUser($id) {
        $arr['user'] = User::findOrFail($id);

        echo json_encode($arr);
    }


    /**
     * ============================================================================
     * Moderator - Moderate Posts - Update post_state in table
     * ============================================================================
     */


    public function editPostState($id, $state) {
        $post = Post::findOrFail($id);
        $post->post_state = $state;
        $post->save();

        // $data = array(
        //     'id' => $id,
        //     'state' => $state,
        // );

        // echo json_encode($data);
    }




    /**
     * ============================================================================
     * Admin - Edit User Role - Update role_id in table
     * ============================================================================
     */


        public function editUserRole($id, $role) {
            $user = User::findOrFail($id);
            $user->role_id = $role;
            $user->save();
        }


    /**
     * ============================================================================
     * Admin - Edit User 
     * ============================================================================
     */


        public function editUser(Request $request) {
            if($request->ajax()) {
                $query = $request->get('query');
                $original_email = $query['original_email'];
                $updated_email = $query['updated_email'];
                $updated_netID = $query['updated_netID'];
                $domain = $query['domain'];
                $original_netID = $query['original_netID'];


                

                // Update the user's email and netID
                $user = User::where('email', $original_email)->first();
                $user->name = $updated_netID;
                $user->email = $updated_email;
                $user->save();

                // Update posts that have original_email set to from_account
                $posts = Post::where('from_account', $original_netID)->get();
                if(count($posts) > 0) {
                    foreach($posts as $k => $post) {
                        $post->from_account = $updated_netID;
                        $post->save();
                    }
                }

                $data = array(
                    'original_email' => $original_email,
                    'updated_email' => $updated_email,
                    'updated_netID' => $updated_netID,
                    'domain' => $domain,
                    'user' => $user,
                    'posts' => $posts,
                );
    
                echo json_encode($data);
            }
        }



    /**
     * ============================================================================
     * Live Search for Posts -- test first
     * route - Route::get('/live-search', 'AjaxController@liveSearch')->name->('ajax.live-search');
     * ============================================================================
     */

    public function liveSearch(Request $request) {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            echo json_encode($query);
            if($query != '') {
                $data = DB::table('posts')
                    ->where('title', 'like', '%' .$query. '%')
                    ->orWhere('from_account', 'like', '%' .$query. '%')
                    ->get();
                    // ->paginate(5)->appends(request()->all());
            } else {
                $data = DB::table('posts')
                    // ->orderBy('created_at', 'desc')->paginate(5)->appends(request()->all());
                    ->orderBy('created_at', 'desc')->get();
            }
            $total_row = $data->count();
            if($total_row > 0) {
                foreach($data as $row) {
                    $output .= '
                    <tr>
                    <td style="text-align:center">'.$row->title.'</td>
                    <td style="text-align:center">'.$row->from_account.'</td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }



    public function liveSearchReadPosts(Request $request) {
        $output = '';
        $query = $request->get('query');
        $POSTpage = $request->get('page');

        // $limit = '10';
        $limit = $this->page_length;
        $page = 1;
        if($POSTpage > 1) {
            $start = (($POSTpage - 1) * $limit);
            $page = $POSTpage;
        } else {
            $start = 0;
        }

        //-- Get All Posts based on input
        if($query != '' && $query != null) {

            $data = Post::where('title', 'like', '%' .$query['title']. '%')
                ->where('from_account', 'like', '%' .$query['from_account']. '%')

                ->when(request('query')['category'] != 0, function($q){
                    return $q->where('category_id', 'like', '%' .request('query')['category']. '%');
                })
                ->orderBy('created_at', 'desc')->get();

        } else {
            $data = Post::orderBy('created_at', 'desc')->get();
        }

        $total_data = $data->count();

        //-- Get Posts based on page chosen in pagination
        $filter_data = Post::where('title', 'like', '%' .$query['title']. '%')
        ->where('from_account', 'like', '%' .$query['from_account']. '%')

        ->when(request('query')['category'] != 0, function($q){
            return $q->where('category_id', 'like', '%' .request('query')['category']. '%');
        })
        ->skip($start)->take($limit)->orderBy('created_at', 'desc')->get();
        $total_filter_data = count($filter_data);



        // $output = '
        // <label>Total Records - '.$total_data.'</label><ul class="read-post-list">
        // ';

        

        if($total_data > 0) {
            foreach($filter_data as $row) {
                $output .= '<li class="li-wrapper">';
                $output .= '<div class="post-list-img">';
                $output .= '<img src="';
                //-- Need to add forward slash
                $output .= asset('/'.'storage'.'/'.$row->image);
                $output .= '" alt="image for the post">';
                $output .= '</div>';//.post-list-img
                $output .= '<div class="post-list-content">';
                $output .= '<h2><a href="';
                $output .= route('show-post', $row->id);
                $output .= '">'.$row->title.'</a></h2>';
                $output .= '<div class="post-list-created-at"><p><em>'.date('m-d-Y',strtotime($row->created_at)).'</em></p></div>';
                $output .= '<div class="post-list-posted-by"><p class="right">Posted By: <span class="bold">'.$row->from_account.'</span></p></div>';
                // $output .= '<div class="post-list-state"><p class="right">Post Status: <span class="bold">'.$row->post_state.'</span></p></div>';
                $output .= '<p class="post-list-summary">'.Str::limit($row->summary, 100).'</p>';
                $output .= '<p class="post-list-category">Category: <span class="bold">'.$row->category->name.'</span></p>';
                $output .= '<p class="post-list-read-more"><a href="';
                $output .= route('show-post', $row->id);
                $output .= '">Read More &rarr;</a></p>';
                $output .= '</div>';//.post-list-content
                $output .= '</li>';
                $output .= '<hr>';
            }
        } else {
            $output .= '<h3 style="font-weight: bold;">No Posts Found</h3>';
        }

        $pagination = '
            <div align="center">
            <ul class="pagination">
        ';
     //========== START PAGINATION CODE 
        $total_links = ceil($total_data/$limit);
        $previous_link = '';
        $next_link = '';
        $page_link = '';
        $page_array = [];



        if($total_links > 4) {
            if($page < 5) {
                for($count = 1; $count <= 5; $count++) {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            } else {
                $end_limit = $total_links - 5;
                if($page > $end_limit) {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $end_limit; $count <= $total_links; $count++) {
                        $page_array[] = $count;
                    }
                } else {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $page - 1; $count <= $page + 1; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        } else {
            for($count = 1; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        }

        for($count = 0; $count < count($page_array); $count++) {
            if($page == $page_array[$count]) {
                $page_link .= '
                <li class="page-item active">
                    <a class="page_link" href="#">'.$page_array[$count].' <span class="sr-only"></span></a>
                </li>
                ';

                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0) {
                    $previous_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                } else {
                    $previous_link = '
                    <li class="page-item disabled">
                    <a class="page_link" href="#">Previous</a>
                    </li>
                    ';
                }
                $next_id = $page_array[$count] + 1;
                if($next_id >= $total_links) {
                    $next_link = '
                    <li class="page-item disabled">
                    <a class="page_link" href="#">Next</a>
                    </li>
                    ';
                } else {
                    $next_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                }
            } else {
                if($page_array[$count] == '...') {
                    $page_link .= '
                    <li class="page-item disabled">
                        <a class="page_link" href="#">...</a>
                    </li>
                    ';
                } else {
                    $page_link .= '
                    <li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
                    ';
                }
            }
        }

        $pagination .= $previous_link . $page_link . $next_link;
        $pagination .= '</ul></div>';
     //========== END PAGINATION CODE 
        $data = [
            'table' => $output,
            'pagination' => $pagination
        ];

        echo json_encode($data);



            
    } // live search pagination end




 
     
    public function liveSearchMyPosts(Request $request) {
        $output = '';
        $query = $request->get('query');
        $POSTpage = $request->get('page');
        $user = Auth::user()->id;
        
        $limit = $this->page_length;
        $page = 1;
        if($POSTpage > 1) {
            $start = (($POSTpage - 1) * $limit);
            $page = $POSTpage;
        } else {
            $start = 0;
        }
        
        //-- Get All Posts based on input
        if($query != '' && $query != null) {
          $data = Post::where('user_id', 'like', '%' .$query['user_id']. '%')
          ->where('title', 'like', '%' .$query['search_my_posts']. '%')
          ->orWhere(function($q) use($query){
              $q->where('user_id', 'like', '%' .$query['user_id']. '%')
                ->where('summary', 'like', '%' . $query['search_my_posts'] . '%');
          })
          ->orderBy('created_at', 'desc')->get();
        } else {
          $data = Post::where('user_id', 'like', '%' .$user. '%')
              ->orderBy('created_at', 'desc')->orderBy('created_at', 'desc')->get();
        }
        $total_data = $data->count();
        
        
        
        
        
        
        
        //-- Get Posts based on page chosen in pagination
        // $filter_data = Post::where('user_id', 'like', '%' .$query['user_id']. '%')
        $filter_data = User::findOrFail($user)->posts()
            ->where('title', 'like', '%' .$query['search_my_posts']. '%')
            ->orWhere(function($q) use($query, $user){
                $q->where('user_id', 'like', '%' .$user. '%')
                ->where('summary', 'like', '%' . $query['search_my_posts'] . '%');
            })->skip($start)->take($limit)->orderBy('created_at', 'desc')->get();

        $total_filter_data = count($filter_data);
        
        
        
        // $output = '
        // <label>Total Records - '.$total_data.'</label><ul class="read-post-list">
        // ';

        // $output = '<ul class="read-post-list">';
        
        if($total_data > 0) {
            foreach($filter_data as $row) {
                $output .= '<li class="li-wrapper">';
                $output .= '<div class="post-list-img">';
                $output .= '<img src="';
                //-- Need to add forward slash
                $output .= asset('/'.'storage'.'/'.$row->image);
                $output .= '" alt="image for the post">';
                $output .= '</div>';//.post-list-img
                $output .= '<div class="post-list-content">';
                $output .= '<h2><a href="';
                $output .= route('show-post', $row->id);
                $output .= '">'.$row->title.'</a></h2>';
                $output .= '<div class="post-list-created-at"><p><em>'.date('m-d-Y',strtotime($row->created_at)).'</em></p></div>';
                $output .= '<div class="post-list-posted-by"><p class="right">Posted By: <span class="bold">'.$row->from_account.'</span></p></div>';
                // $output .= '<div class="post-list-state"><p class="right">Post Status: <span class="bold">'.$row->post_state.'</span></p></div>';
                $output .= '<p class="post-list-summary">'.Str::limit($row->summary, 100).'</p>';
                $output .= '<p class="post-list-category">Category: <span class="bold">'.$row->category->name.'</span></p>';
                $output .= '<p class="post-list-read-more"><a href="';
                $output .= route('show-post', $row->id);
                $output .= '">Read More &rarr;</a></p>';
                $output .= '</div>';//.post-list-content
                $output .= '</li>';
                $output .= '<hr>';
            }
        } elseif($total_data == 0) {
            $output .= '
            <h3 style="font-weight: bold;">No Posts Found</h3>
            ';
        }
        
        $pagination = '
            <div align="center">
            <ul class="pagination">
        ';
     //========== START PAGINATION CODE 
        $total_links = ceil($total_data/$limit);
        $previous_link = '';
        $next_link = '';
        $page_link = '';
        $page_array = [];
        
        
        
        if($total_links > 4) {
            if($page < 5) {
                for($count = 1; $count <= 5; $count++) {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            } else {
                $end_limit = $total_links - 5;
                if($page > $end_limit) {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $end_limit; $count <= $total_links; $count++) {
                        $page_array[] = $count;
                    }
                } else {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $page - 1; $count <= $page + 1; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        } else {
            for($count = 1; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        }
        
        for($count = 0; $count < count($page_array); $count++) {
            if($page == $page_array[$count]) {
                $page_link .= '
                <li class="page-item active">
                    <a class="page_link" href="#">'.$page_array[$count].' <span class="sr-only"></span></a>
                </li>
                ';
        
                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0) {
                    $previous_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                } else {
                    $previous_link = '
                    <li class="page-item disabled">
                    <a class="page_link" href="#">Previous</a>
                    </li>
                    ';
                }
                $next_id = $page_array[$count] + 1;
                if($next_id >= $total_links) {
                    $next_link = '
                    <li class="page-item disabled">
                    <a class="page_link" href="#">Next</a>
                    </li>
                    ';
                } else {
                    $next_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                }
            } else {
                if($page_array[$count] == '...') {
                    $page_link .= '
                    <li class="page-item disabled">
                        <a class="page_link" href="#">...</a>
                    </li>
                    ';
                } else {
                    $page_link .= '
                    <li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
                    ';
                }
            }
        }
        
        $pagination .= $previous_link . $page_link . $next_link;
        $pagination .= '</ul></div>';
     //========== END PAGINATION CODE 
        $data = [
            'table' => $output,
            'pagination' => $pagination
        ];

        echo json_encode($data);
        
       
        
            
    } // live search pagination end












    public function liveSearchContribPostsStatus(Request $request) {
            $output = '';
            $query = $request->get('query');
            $POSTpage = $request->get('page');
            $user = Auth::user()->id;


            $limit = $this->page_length;
            $page = 1;
            if($POSTpage > 1) {
                $start = (($POSTpage - 1) * $limit);
                $page = $POSTpage;
            } else {
                $start = 0;
            }


            if($query != '' || $query != null) {
                $data = Post::where('user_id', 'like', '%' .$query['user_id']. '%')
                    ->where('title', 'like', '%' .$query['posts_status']. '%')
                    // ->orWhere('from_account', 'like', '%' .$query['posts_status']. '%')
                    ->orderBy('created_at', 'desc')->get();
            } 
            else {
                $data = Post::where('user_id', 'like', '%' .$user. '%')
                ->orderBy('created_at', 'desc')->get();
            }
            $total_data = $data->count();



            $filter_data = Post::where('user_id', 'like', '%' .$user. '%')
                ->where('title', 'like', '%' .$query['posts_status']. '%')
                // ->orWhere('from_account', 'like', '%' .$query['posts_status']. '%')
                ->skip($start)->take($limit)->orderBy('created_at', 'desc')->get();
            $total_filter_data = count($filter_data);


            // $output = '<table class="table">
            //             <thead>
            //             <tr>
            //             <th>Title</th>
            //             <th>Posted By</th>
            //             <th class="mp-update-at">Updated At</th>
            //             <th class="mp-state">State</th>
            //             </tr>
            //             </thead>
            //             <tbody>';

            if($total_data > 0) {
                foreach($filter_data as $row) {
                    $output .= '<tr>';
                    $output .= '<td style="text-align:center">'.$row->title.'</td>';
                    $output .= '<td style="text-align:center">'.$row->from_account.'</td>';
                    $output .= '<td class="mp-update-at" style="text-align:center">'.date('m-d-Y h:i:s A',strtotime($row->updated_at)).'</td>';
                    $output .= '<td class="mp_state" style="text-align:center">'.$row->post_state.'</td>';
                    $output .= '</tr>';
                }
            } else {
                $output.= '<tr><td colspan="4" style="text-align:center"><h3 style="font-weight: bold;">No Posts Found</h3></td></tr>';
            }

            // $output .= '</tbody>
            //             <tfoot>
            //             <tr>
            //             <th>Title</th>
            //             <th>Posted By</th>
            //             <th class="mp-update-at">Updated At</th>
            //             <th class="mp-state">State</th>
            //             </tr>
            //             </tfoot>
            //             </table>
            //             <br />
            //             <div align="center">
            //             <ul class="pagination">';

            $pagination = '<div align="center">
                           <ul class="pagination">';
         //========== START PAGINATION CODE 
            $total_links = ceil($total_data/$limit);
            $previous_link = '';
            $next_link = '';
            $page_link = '';
            $page_array = [];

            if($total_links > 4) {
                if($page < 5) {
                    for($count = 1; $count <= 5; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                } else {
                    $end_limit = $total_links - 5;
                    if($page > $end_limit) {
                        $page_array[] = 1;
                        $page_array[] = '...';
                        for($count = $end_limit; $count <= $total_links; $count++) {
                            $page_array[] = $count;
                        }
                    } else {
                        $page_array[] = 1;
                        $page_array[] = '...';
                        for($count = $page - 1; $count <= $page + 1; $count++) {
                            $page_array[] = $count;
                        }
                        $page_array[] = '...';
                        $page_array[] = $total_links;
                    }
                }
            } else {
                for($count = 1; $count <= $total_links; $count++) {
                    $page_array[] = $count;
                }
            }


            for($count = 0; $count < count($page_array); $count++) {
                if($page == $page_array[$count]) {
                    $page_link .= '
                    <li class="page-item active">
                        <a class="page_link" href="#">'.$page_array[$count].' <span class="sr-only"></span></a>
                    </li>
                    ';
            
                    $previous_id = $page_array[$count] - 1;
                    if($previous_id > 0) {
                        $previous_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                    } else {
                        $previous_link = '
                        <li class="page-item disabled">
                        <a class="page_link" href="#">Previous</a>
                        </li>
                        ';
                    }
                    $next_id = $page_array[$count] + 1;
                    if($next_id >= $total_links) {
                        $next_link = '
                        <li class="page-item disabled">
                        <a class="page_link" href="#">Next</a>
                        </li>
                        ';
                    } else {
                        $next_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                    }
                } else {
                    if($page_array[$count] == '...') {
                        $page_link .= '
                        <li class="page-item disabled">
                            <a class="page_link" href="#">...</a>
                        </li>
                        ';
                    } else {
                        $page_link .= '
                        <li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
                        ';
                    }
                }
            }

            $pagination .= $previous_link . $page_link . $next_link;
            $pagination .= '</ul></div>';
         //========== END PAGINATION CODE 
            $data = [
                'table' => $output,
                'pagination' => $pagination,
                'query' => $query,
            ];

            echo json_encode($data);
    }



    public function liveSearchModPostsStatus(Request $request) {

        $output = '';
        $query = $request->get('query');
        $POSTpage = $request->get('page');
        $user = Auth::user()->id;



        $limit = $this->page_length;
        $page = 1;
        if($POSTpage > 1) {
            $start = (($POSTpage - 1) * $limit);
            $page = $POSTpage;
        } else {
            $start = 0;
        }




        if($query != '' || $query != null) {
            $data = Post::where('post_state', '!=', 'Published')
                ->where('title', 'like', '%' .$query['posts_status']. '%')
                ->orWhere(function($q) use($query){
                    $q->where('post_state', '!=', 'Published')
                        ->where('from_account', 'like', '%' . $query['posts_status'] . '%');
                })
                ->orderBy('updated_at', 'desc')->get();
        } else {
            $data = Post::where('post_state', '!=', 'Published')
            ->orderBy('updated_at', 'desc')->get();
        }
        $total_data = $data->count();


        $filter_data = Post::where('post_state', '!=', 'Published')
            ->where('title', 'like', '%' .$query['posts_status']. '%')
            ->orWhere(function($q) use($query){
                $q->where('post_state', '!=', 'Published')
                ->where('from_account', 'like', '%' . $query['posts_status'] . '%');
            })
            ->skip($start)->take($limit)->orderBy('updated_at', 'desc')->get();

        $total_filter_data = count($filter_data);




        // $output = '<table class="table">
        //             <thead>
        //             <tr>
        //             <th>Title</th>
        //             <th>Posted By</th>
        //             <th class="mp-update-at">Updated At</th>
        //             <th class="mp-state">State</th>
        //             <th>Edit</th>
        //             </tr>
        //             </thead>
        //             <tbody>';

        if($total_data > 0) {
            foreach($filter_data as $row) {
                $output .= '
                    <tr>
                        <td style="text-align:center">'.$row->title.'</td>
                        <td style="text-align:center">'.$row->from_account.'</td>
                        <td class="mp-update-at" style="text-align:center">'.date('m-d-Y h:i:s A',strtotime($row->updated_at)).'</td>
                        <td class="mp_state" style="text-align:center">';


                // $output .= '<td>';
                $output .= '<select class="post_status_select" id="'.$row->id.'" name="post_state_select">';
                if($row->post_state == 'Needs Review'){
                    $output .= '<option id="Needs Review" value="Needs Review" selected>Needs Review</option>';
                    $output .= '<option id="Publish" value="Publish">Publish</option>';
                } elseif($row->post_state == 'Publish') {
                    $output .= '<option id="Needs Review" value="Needs Review">Needs Review</option>';
                    $output .= '<option id="Publish" value="Publish" selected>Publish</option>';
                }
                $output .= '</select>';
                $output .= '</td>';
                $output .= '<td><a href="'.route('edit-post', $row->id).'" class="btn btn-login">Edit Post</a></td>';
                $output .= '</tr>';

            }
        } else {
            $output .= '<tr><td colspan="5" style="text-align:center"><h3 style="font-weight: bold;">No Posts Found</h3></td></tr>';
        }

        // $output .= '</tbody>
        //             <tfoot>
        //             <tr>
        //             <th>Title</th>
        //             <th>Posted By</th>
        //             <th class="mp-update-at">Updated At</th>
        //             <th class="mp-state">State</th>
        //             <th>Edit</th>
        //             </tr>
        //             </tfoot>
        //             </table>
        //             <br />
        //             <div align="center">
        //             <ul class="pagination">';

        $pagination = '<div align="center">
                       <ul class="pagination">';
        
     //========== START PAGINATION CODE 
        $total_links = ceil($total_data/$limit);
        $previous_link = '';
        $next_link = '';
        $page_link = '';
        $page_array = [];


        if($total_links > 4) {
            if($page < 5) {
                for($count = 1; $count <= 5; $count++) {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            } else {
                $end_limit = $total_links - 5;
                if($page > $end_limit) {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $end_limit; $count <= $total_links; $count++) {
                        $page_array[] = $count;
                    }
                } else {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $page - 1; $count <= $page + 1; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        } else {
            for($count = 1; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        }

        for($count = 0; $count < count($page_array); $count++) {
            if($page == $page_array[$count]) {
                $page_link .= '
                <li class="page-item active">
                    <a class="page_link" href="#">'.$page_array[$count].' <span class="sr-only"></span></a>
                </li>
                ';
        
                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0) {
                    $previous_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                } else {
                    $previous_link = '
                    <li class="page-item disabled">
                    <a class="page_link" href="#">Previous</a>
                    </li>
                    ';
                }
                $next_id = $page_array[$count] + 1;
                if($next_id >= $total_links) {
                    $next_link = '
                    <li class="page-item disabled">
                    <a class="page_link" href="#">Next</a>
                    </li>
                    ';
                } else {
                    $next_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                }
            } else {
                if($page_array[$count] == '...') {
                    $page_link .= '
                    <li class="page-item disabled">
                        <a class="page_link" href="#">...</a>
                    </li>
                    ';
                } else {
                    $page_link .= '
                    <li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
                    ';
                }
            }
        }

        $pagination .= $previous_link . $page_link . $next_link;
        $pagination .= '</ul></div>';
     //========== END PAGINATION CODE 

        $data = [
            'table' => $output,
            'pagination' => $pagination
        ];

        echo json_encode($data);
    }


    public function liveSearchAdminPostsStatus(Request $request) {

            $output = '';
            $query = $request->get('query');
            $POSTpage = $request->get('page');
            $user = Auth::user()->id;


            $limit = $this->page_length;
            $page = 1;
            if($POSTpage > 1) {
                $start = (($POSTpage - 1) * $limit);
                $page = $POSTpage;
            } else {
                $start = 0;
            }



            if($query != '' || $query != null) {
                $data = Post::where('title', 'like', '%' .$query['posts_status']. '%')
                    ->orWhere('from_account', 'like', '%' .$query['posts_status']. '%')
                    ->orderBy('updated_at', 'desc')->get();
            } else {
                $data = Post::orderBy('updated_at', 'desc')->get();
            }
            $total_data = $data->count();



            $filter_data = Post::where('title', 'like', '%' .$query['posts_status']. '%')
                ->orWhere('from_account', 'like', '%' .$query['posts_status']. '%')
                ->skip($start)->take($limit)->orderBy('updated_at', 'desc')->get();
            $total_filter_data = count($filter_data);




            if($total_data > 0) {
                foreach($filter_data as $row) {
                        $output .= '
                            <tr>
                                <td style="text-align:center">'.$row->title.'</td>
                                <td style="text-align:center">'.$row->from_account.'</td>
                                <td class="mp-update-at" style="text-align:center">'.date('m-d-Y h:i:s A',strtotime($row->updated_at)).'</td>
                                <td class="mp_state" style="text-align:center">';


                        // $output .= '<td>';
                        $output .= '<select class="post_status_select" id="'.$row->id.'" name="post_state_select">';
                        if($row->post_state == 'Needs Review'){
                            $output .= '<option id="Needs Review" value="Needs Review" selected>Needs Review</option>';
                            $output .= '<option id="Publish" value="Publish">Publish</option>';
                            $output .= '<option id="Published" value="Published">Published</option>';
                        } elseif($row->post_state == 'Publish') {
                            $output .= '<option id="Needs Review" value="Needs Review">Needs Review</option>';
                            $output .= '<option id="Publish" value="Publish" selected>Publish</option>';
                            $output .= '<option id="Published" value="Published">Published</option>';
                        } elseif($row->post_state == 'Published') {
                            $output .= '<option id="Needs Review" value="Needs Review">Needs Review</option>';
                            $output .= '<option id="Publish" value="Publish">Publish</option>';
                            $output .= '<option id="Published" value="Published" selected>Published</option>';
                        }
                        $output .= '</select>';
                        $output .= '</td>';
                        $output .= '<td><a href="'.route('edit-post', $row->id).'" class="btn btn-login">Edit Post</a></td>';
                        $output .= '</tr>';

                }
            } else {
                $output .= '<tr><td colspan="5" style="text-align:center"><h3 style="font-weight: bold;">No Posts Found</h3></td></tr>';
            }
            
            $pagination = '
                    <div align="center">
                    <ul class="pagination">';


        //========== START PAGINATION CODE 
            $total_links = ceil($total_data/$limit);
            $previous_link = '';
            $next_link = '';
            $page_link = '';
            $page_array = [];



            if($total_links > 4) {
                if($page < 5) {
                    for($count = 1; $count <= 5; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                } else {
                    $end_limit = $total_links - 5;
                    if($page > $end_limit) {
                        $page_array[] = 1;
                        $page_array[] = '...';
                        for($count = $end_limit; $count <= $total_links; $count++) {
                            $page_array[] = $count;
                        }
                    } else {
                        $page_array[] = 1;
                        $page_array[] = '...';
                        for($count = $page - 1; $count <= $page + 1; $count++) {
                            $page_array[] = $count;
                        }
                        $page_array[] = '...';
                        $page_array[] = $total_links;
                    }
                }
            } else {
                for($count = 1; $count <= $total_links; $count++) {
                    $page_array[] = $count;
                }
            }
    
            for($count = 0; $count < count($page_array); $count++) {
                if($page == $page_array[$count]) {
                    $page_link .= '
                    <li class="page-item active">
                        <a class="page_link" href="#">'.$page_array[$count].' <span class="sr-only"></span></a>
                    </li>
                    ';
            
                    $previous_id = $page_array[$count] - 1;
                    if($previous_id > 0) {
                        $previous_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                    } else {
                        $previous_link = '
                        <li class="page-item disabled">
                        <a class="page_link" href="#">Previous</a>
                        </li>
                        ';
                    }
                    $next_id = $page_array[$count] + 1;
                    if($next_id >= $total_links) {
                        $next_link = '
                        <li class="page-item disabled">
                        <a class="page_link" href="#">Next</a>
                        </li>
                        ';
                    } else {
                        $next_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                    }
                } else {
                    if($page_array[$count] == '...') {
                        $page_link .= '
                        <li class="page-item disabled">
                            <a class="page_link" href="#">...</a>
                        </li>
                        ';
                    } else {
                        $page_link .= '
                        <li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
                        ';
                    }
                }
            }
    
            $pagination .= $previous_link . $page_link . $next_link;
            $pagination .= '</ul></div>';
        //========== END PAGINATION CODE 

            $data = [
                'table' => $output,
                'pagination' => $pagination
            ];

            echo json_encode($data);

    }


 


    /**
     * For Mod->Moderate Contributors 
     * 
     */
    public function liveSearchContributors(Request $request) {

        $output = '';
        $query = $request->get('query');
        $POSTpage = $request->get('page');
        $user = Auth::user()->id;


        $limit = $this->page_length;
        $page = 1;
        if($POSTpage > 1) {
            $start = (($POSTpage - 1) * $limit);
            $page = $POSTpage;
        } else {
            $start = 0;
        }


        if($query != '' || $query != null) {
            $data = User::where('role_id', 2)
                ->where('name', 'like', '%' .$query['search_contributors']. '%')
                ->orderBy('created_at', 'desc')->get();
        } else {
            $data = User::where('role_id', 2)
            ->orderBy('created_at', 'desc')->get();
        }
        $total_data = $data->count();



        $filter_data = User::where('role_id', 2)
            ->where('name', 'like', '%' .$query['search_contributors']. '%')
            ->skip($start)->take($limit)->orderBy('created_at', 'desc')->get();

        $total_filter_data = count($filter_data);






        // $output = '<table class="table">
        //             <thead>
        //             <tr>
        //             <th>netID</th>
        //             <th>Added At</th>
        //             </tr>
        //             </thead>
        //             <tbody id="contributor_list">';

        if($total_data > 0) {
            foreach($filter_data as $row) {
                $output .= '
                    <tr>
                        <td style="text-align:center">'.$row->name.'</td>
                        <td style="text-align:center">'.date('m-d-Y h:i:s A',strtotime($row->created_at)).'</td>';
                $output .= '</tr>';          
            }
        } else {
            $output .= '<tr>
                        <td colspan="2" style="text-align:center">
                        <h3 style="font-weight: bold;">No Contributors Found</h3>
                        </td>
                        </tr>';
        }
        // $output .= '</tbody>
        //             <tfoot>
        //             <tr>
        //             <th>netID</th>
        //             <th>Added At</th>
        //             </tr>
        //             </tfoot>
        //             </table>
        //             <br />
        //             <div align="center">
        //             <ul class="pagination">';
        $pagination = '<div align="center"><ul class="pagination">';

     //========== START PAGINATION CODE 
        $total_links = ceil($total_data/$limit);
        $previous_link = '';
        $next_link = '';
        $page_link = '';
        $page_array = [];


        if($total_links > 4) {
            if($page < 5) {
                for($count = 1; $count <= 5; $count++) {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            } else {
                $end_limit = $total_links - 5;
                if($page > $end_limit) {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $end_limit; $count <= $total_links; $count++) {
                        $page_array[] = $count;
                    }
                } else {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $page - 1; $count <= $page + 1; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        } else {
            for($count = 1; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        }


        for($count = 0; $count < count($page_array); $count++) {
            if($page == $page_array[$count]) {
                $page_link .= '
                <li class="page-item active">
                    <a class="page_link" href="#">'.$page_array[$count].' <span class="sr-only"></span></a>
                </li>
                ';
        
                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0) {
                    $previous_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                } else {
                    $previous_link = '
                    <li class="page-item disabled">
                    <a class="page_link" href="#">Previous</a>
                    </li>
                    ';
                }
                $next_id = $page_array[$count] + 1;
                if($next_id >= $total_links) {
                    $next_link = '
                    <li class="page-item disabled">
                    <a class="page_link" href="#">Next</a>
                    </li>
                    ';
                } else {
                    $next_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                }
            } else {
                if($page_array[$count] == '...') {
                    $page_link .= '
                    <li class="page-item disabled">
                        <a class="page_link" href="#">...</a>
                    </li>
                    ';
                } else {
                    $page_link .= '
                    <li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
                    ';
                }
            }
        }

        $pagination .= $previous_link . $page_link . $next_link;
        $pagination .= '</ul></div>';
     //========== END PAGINATION CODE     

        $data = [
            'table' => $output,
            'pagination' => $pagination
        ];

        echo json_encode($data);

    }




    /**
     * For Admin->Moderate Users 
     * 
     */
    public function liveSearchUsers(Request $request) {
            $output = '';
            $user_pair_alias = '';
            $query = $request->get('query');
            $POSTpage = $request->get('page');
            $user = Auth::user()->id;
            $roles = Role::get();


            $limit = $this->page_length;
            $page = 1;
            if($POSTpage > 1) {
                $start = (($POSTpage - 1) * $limit);
                $page = $POSTpage;
            } else {
                $start = 0;
            }




            if($query != '' || $query != null) {
                $data = User::where('name', 'like', '%' .$query['search_users']. '%')
                    ->when(request('query')['role'] != 0, function($q){
                        return $q->where('role_id', 'like', '%' .request('query')['role']. '%');
                    })
                    ->orderBy('created_at', 'desc')->get();
            } else {
                $data = User::
                    orderBy('created_at', 'desc')->get();
            }
            $total_data = $data->count();




            $filter_data = User::where('name', 'like', '%' .$query['search_users']. '%')
                ->when(request('query')['role'] != 0, function($q){
                    return $q->where('role_id', 'like', '%' .request('query')['role']. '%');
                })
                ->skip($start)->take($limit)->orderBy('created_at', 'desc')->get();
            $total_filter_data = count($filter_data);

            

            if($total_data > 0) {
                foreach($filter_data as $row) {
                    $output .= '<tr><td style="text-align:center">'.$row->name.'</td>';

                    $output .= '<td style="text-align:center"><a class="hover btn btn-login open_edit_user_email_modal">'.$row->email.'</a></td>';

                    $output .= '<td>';
                    $output .= '<select class="user_role_select" id="'.$row->id.'" name="user_role_select">';
                    foreach($roles as $role) {
                        if($row->role_id == $role->id) {
                            $output .= '<option id="'.$role->name.'" value="'.$role->id.'" selected>'.$role->name.'</option>';
                        } else {
                            $output .= '<option id="'.$role->name.'" value="'.$role->id.'">'.$role->name.'</option>';
                        }
                    }
                    $output .= '</select>';
                    $output .= '</td>';
                    if($row->last_login == null) {
                        $output .= '<td class="mu-hide" style="text-align:center">'.'<span style="font-weight:bold;">Has not logged in</span>'.'</td>';
                    } else {
                        $output .= '<td class="mu-hide" style="text-align:center">'.date('m-d-Y h:i:s A',strtotime($row->last_login)).'</td>';
                    }
                    $output .= '<td class="mu-hide" style="text-align:center">'.date('m-d-Y h:i:s A',strtotime($row->created_at)).'</td>';
                    $output .= '<td style="text-align:center"><a id="'.$row->id.' '.$row->email.'" class="hover btn btn-login open_delete_user_modal">Delete</a></td>';
                    $output .= '</tr>';          
                }
            } else {
                $output .= '<tr>
                        <td colspan="4" style="text-align:center">
                        <h3 style="font-weight: bold;">No Users Found</h3>
                        </td>
                        </tr>';
            }


            $pagination = '
                    <div align="center">
                    <ul class="pagination">';

     //========== START PAGINATION CODE 
            $total_links = ceil($total_data/$limit);
            $previous_link = '';
            $next_link = '';
            $page_link = '';
            $page_array = [];


            if($total_links > 4) {
                if($page < 5) {
                    for($count = 1; $count <= 5; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                } else {
                    $end_limit = $total_links - 5;
                    if($page > $end_limit) {
                        $page_array[] = 1;
                        $page_array[] = '...';
                        for($count = $end_limit; $count <= $total_links; $count++) {
                            $page_array[] = $count;
                        }
                    } else {
                        $page_array[] = 1;
                        $page_array[] = '...';
                        for($count = $page - 1; $count <= $page + 1; $count++) {
                            $page_array[] = $count;
                        }
                        $page_array[] = '...';
                        $page_array[] = $total_links;
                    }
                }
            } else {
                for($count = 1; $count <= $total_links; $count++) {
                    $page_array[] = $count;
                }
            }
    
            for($count = 0; $count < count($page_array); $count++) {
                if($page == $page_array[$count]) {
                    $page_link .= '
                    <li class="page-item active">
                        <a class="page_link" href="#">'.$page_array[$count].' <span class="sr-only"></span></a>
                    </li>
                    ';
                    // (current) in span
            
                    $previous_id = $page_array[$count] - 1;
                    if($previous_id > 0) {
                        $previous_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                    } else {
                        $previous_link = '
                        <li class="page-item disabled">
                        <a class="page_link" href="#">Previous</a>
                        </li>
                        ';
                    }
                    $next_id = $page_array[$count] + 1;
                    if($next_id >= $total_links) {
                        $next_link = '
                        <li class="page-item disabled">
                        <a class="page_link" href="#">Next</a>
                        </li>
                        ';
                    } else {
                        $next_link = '<li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                    }
                } else {
                    if($page_array[$count] == '...') {
                        $page_link .= '
                        <li class="page-item disabled">
                            <a class="page_link" href="#">...</a>
                        </li>
                        ';
                    } else {
                        $page_link .= '
                        <li class="page-item"><a class="page_link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
                        ';
                    }
                }
            }
    
            // $output .= $previous_link . $page_link . $next_link;
            // $output .= '</ul></div>';
            $pagination .= $previous_link . $page_link . $next_link;
            $pagination .= '</ul></div>';
     //========== END PAGINATION CODE 

            $data = [
                'table' => $output,
                'pagination' => $pagination
            ];

            echo json_encode($data);
    }



    /**
     * For Admin->Settings 
     * Search Users to pair account/alias name with 
     */
    public function searchUsersPairAccount(Request $request) {
        if($request->ajax()) {
            $output = '';
            $user_pair_alias = '';
            $query = $request->get('query');
            $user = Auth::user()->id;


            if($query['search_users'] != '' || $query['search_users'] != null) {
                $data = User::where('name', 'like', '%' .$query['search_users']. '%')
                    ->get();
            } else {
                $data = [];
            }

            if(!empty($data)) {
                $total_row = $data->count();
            } else {
                $total_row = 0;
                $user_pair_alias = '<h3>No User Selected</h3>';
            }
            

            //---- Need an if statement that checks if the current url is admin.settings... 
            //------ If it is, the $data query does not query anything if $query is null || an empty string

            //---- GOT THE RELATED ACCOUNT NAMES TO DISPLAY WITH THE USER ----//
            if($total_row > 0) {
                foreach($data as $row) {
                    $pivot = User::findOrFail($row->id)->accounts()->get();
                    
                    $user_pair_alias .= '<p>'.$row->name.'</p>';    
                    $user_pair_alias .= '<div id="user_'.$row->id.'" class="users_alias_box" >';

                    foreach($pivot as $account) {
                        $user_pair_alias .= '<p class="account_draggable" id="'.$account->id.'">'.$account->name.'<span style="font-weight:bold; padding: 10px"> &times;</span></p>';
                    }
                    $user_pair_alias .= '</div>';     
                }
            } else {
                $user_pair_alias = '<h3>No User Selected</h3>';
            }

            $data = array(
                'user_pair_alias' => $user_pair_alias,
            );

            echo json_encode($data);
        }
    }



    /**
     * For Admin->Settings 
     * Detach an account from a user many-to-many relationship
     * 
     * 1) Pass in user and account id 
     * 2) Query User 
     * 
     */
    public function detachUserAccountPair(Request $request) {
        if($request->ajax()) {
            $user_id = $request->get('user_id');
            $account_id = $request->get('account_id');

            if($user_id != '' && $account_id != '' && $user_id != null && $account_id != null) {
                User::findOrFail($user_id)->accounts()->detach($account_id);
                $result = 'detach success';
            } else {
                $result = 'detach fail';
            }

            $data = array(
                'user_id' => $user_id,
                'account_id' => $account_id,
                'result' => $result,
            );

            echo json_encode($data);
        }
    }

    /**
     * For Admin->Settings 
     * Attach an account to a user many-to-many relationship
     * 
     * 
     */
    public function attachUserAccountPair(Request $request) {
        if($request->ajax()) {
            $user_id = $request->get('user_id');
            $account_id = $request->get('account_id');

            if($user_id != '' && $account_id != '' && $user_id != null && $account_id != null) {
                User::findOrFail($user_id)->accounts()->attach($account_id);
                $result = 'attach success';
            } else {
                $result = 'attach fail';
            }

            $data = array(
                'user_id' => $user_id,
                'account_id' => $account_id,
                'result' => $result,
            );

            echo json_encode($data);
        }
    }



    /**
     * For Mod->Moderate Contributors
     */
    public function addContributor(Request $request) {
        if($request->ajax()) {
            $query = $request->get('query');

            $query_user = User::where('email', $query['email'])->first();

            // If user enter their own email
            if($query_user && $query_user->email == Auth::user()->email) {
                // session()->flash('contributor-you-message', 'Cannot make yourself a Contributor.');
            

            // If user enters a valid email and not their own email
            } elseif($query_user && $query_user->email != Auth::user()->email) {
                $query_user->role_id = 2;
                $query_user->save();
                // session()->flash('contributor-created-message', 'The user is now a Contributor!');


            // If user enters a valid email that is not already in the User table
            } elseif($query_user === null) {
                $user = new User;
                $user->role_id = 2;
                $user->name = $query['name'];
                $user->email = $query['email'];
                $user->save();
                // session()->flash('contributor-created-message', 'The user is now a Contributor!');
            }

            $data = array(
                'input_query' => $query,
                'query_user' => $query_user,
                // 'user' => $user,
            );
            session()->flash('contributor-created-message', 'User was created');

            echo json_encode($data);
        }
    }


    /**
     * For Admin->Moderate Users
     */
    public function addUser(Request $request) {
        if($request->ajax()) {
            $output = '';
            $query = $request->get('query');


            $query_user = User::where('email', $query['email'])->first();
            // dd($query);

            if($query_user) {
                session()->flash('user-exists-message', 'The user already exists.');
                $the_user = 'the user exists';
            } else {
                $the_user = 'the user has been created';
                $user = new User;
                $user->role_id = $query['role_id'];
                $user->name = $query['name'];
                $user->email = $query['email'];
                $user->save();
                session()->flash('user-created-message', 'The user has now been added!');
            }


            $data = array(
                'query' => $query,
                'user' => $the_user
            );

            echo json_encode($data);
        }
    }



    /**
     * For Moderator->Add Contributors
     */
    public function getCurrentUser(Request $request) {
        
        $currentUser = User::findOrFail(Auth::user()->id);
        
            $data = array(
                'currentUser' => $currentUser,
            );

            echo json_encode($data);
        
    }


    /**
     * For Moderator->Add Contributors
     */
    public function checkAdminEmail(Request $request) {
        
        if($request->ajax()) {
            $email = $request->get('email');
            $query = User::where('email', $email)->first();
            $isAdminOrMod = false;

            if($query !== null) {
                if($query->role_id == 4 || $query->role_id == 3) {
                    $isAdminOrMod = true;
                    $user_role_id = $query->role_id;
                    $user_email = $query->email;
                } else {
                    $isAdminOrMod = false;
                }
            } else {
                $isAdminOrMod = false;
            }
        }
        
            $data = array(
                // 'user_role_id' => $user_role_id,
                'query' => $query,
                'isAdminOrMod' => $isAdminOrMod,
            );

            echo json_encode($data);
        
    }



    /**
     * For Moderator->Add Contributors
     * For Admin->Add Users
     */
    public function checkIfUserExists(Request $request) {
        
        if($request->ajax()) {
            $netID = $request->get('netID');
            $query = User::where('name', $netID)->first();
            $userExists = false;

            if($query !== null) {
                $userExists = true;
            } 
        }
        
            $data = array(
                'query' => $query,
                'userExists' => $userExists,
            );

            echo json_encode($data);
        
    }







    /**
     * ============================================================================
     * Admin Settings - Categories
     * ============================================================================
     */








    /**
     * ============================================================================
     * Admin Settings - Alias Names
     * ============================================================================
     */

        // get all account/alias names to be able to edit
        public function getAccountsEdit() {
            $query = Account::get();
            $output = '';
            $total_row = $query->count();
            $alias_names = [];

            foreach($query as $alias) {
                array_push($alias_names, $alias->name);
            }
            
                if($total_row > 0) {
                    foreach($query as $row) {
                        $output .= '
                        <tr>
                            <td id="account_'.$row->id.'" class="accounts" style="text-align:center">'.$row->name.'</td>
                        </tr>
                        ';
                    }
                } else {
                    $output = '
                    <tr>
                        <td align="center" colspan="5">No Accounts Found</td>
                    </tr>
                    ';
                }

            $data = array(
                'accounts' => $query,
                'total_rows' => $total_row,
                'output' => $output,
                'alias_names' => $alias_names,
            );
            echo json_encode($data);
        }


        // get account user wants to edit and load it into modal window
        public function getAccount($id) {
            $query = Account::findOrFail($id);
            $output = '';
            $total_row = $query->count();
                if($total_row > 0) {
                    foreach($query as $row) {
                        $output = $query;
                    }
                } else {
                    $output = 'No Account';
                }

            $data = array(
                // 'account' => $query,
                // 'total rows' => $total_row,
                'output' => $output,
            );
            echo json_encode($data);
        }


        // update the account name in accounts table after user edits
        public function editAccount($id, $value) {
            $query = Account::findOrFail($id);
            $query->name = $value;
            $query->save();

            $data = array(
                'acct_id' => $id,
                'value' => $value,
                'output' => 'account updated',
                'settings_route' => route('settings'),
            );
            echo json_encode($data);
        }

        // add new account to accounts table 
        public function addAccount(Request $request) {
            if($request->ajax()) {
                $output = '';
                $query = $request->get('query');


                // $query_user = User::where('email', $query['email'])->first();
                // dd($query);

                // if($query_user) {
                    // session()->flash('user-exists-message', 'The user already exists.');
                    // $the_user = 'the user exists';
                // } else {
                    // $the_user = 'the user has been created';


                    $account = new Account;
                    $account->name = $query;
                    $account->save();


                    // session()->flash('user-created-message', 'New category has been added!');
                // }


                $data = array(
                    'query' => $query,
                    'settings_route' => route('settings'),
                );

                echo json_encode($data);
            }
        }

        


    /**
     * =============================================================================== 
     * Admin Settings - Toast Settings
     * ===============================================================================
     */

        // IDK WHERE ITS USED
        public function setToastPositionOptions(Request $request) {
            if($request->ajax()) {
                //-- Get Toast
                $toast_name = $request->get('toast');
                $toast = Toast::where('title', $toast_name)->first();


                //-- Get Toast Positions
                $positions = Position::all();

                //-- Get Toast Messages
                $messages = Message::all();


                $data = array(
                    // 'toast_name' => $toast_name,
                    'toast' => $toast,
                    'toast_position' => $toast->position->name,
                    'toast_message' => $toast->message->message,
                    'positions' => $positions,
                    'messages' => $messages,
                    
                );

                echo json_encode($data);
            }
        }

        // IDK WHERE ITS USED
        public function getToasts(Request $request) {
            if($request->ajax()) {
                $toasts = Toast::all();              

                $create_post_toast;
                $update_post_toast;
                $contributor_toast;
                $update_user_toast;
                $create_user_toast;


                foreach($toasts as $toast) {
                    if($toast->title == 'create post') {
                        $create_post_toast["position"] = $toast->position->name;
                        $create_post_toast["message"] = $toast->message->message;
                        // array_push($toasts_arry, $create_post_toast);
                        $toasts_arry['create post'] = $create_post_toast;
                    }
                    
                    if($toast->title == 'update post') {
                        $update_post_toast["position"] = $toast->position->name;
                        $update_post_toast["message"] = $toast->message->message;
                        // array_push($toasts_arry, $update_post_toast);
                        $toasts_arry['update post'] = $update_post_toast;
                    }

                    if($toast->title == 'contributor') {
                        $contributor_toast["position"] = $toast->position->name;
                        $contributor_toast["message"] = $toast->message->message;
                        // array_push($toasts_arry, $contributor_toast);
                        $toasts_arry['contributor'] = $contributor_toast;
                    }

                    if($toast->title == 'update user') {
                        $update_user_toast["position"] = $toast->position->name;
                        $update_user_toast["message"] = $toast->message->message;
                        // array_push($toasts_arry, $update_user_toast);
                        $toasts_arry['update user'] = $update_user_toast;
                    }

                    if($toast->title == 'create user') {
                        $create_user_toast["position"] = $toast->position->name;
                        $create_user_toast["message"] = $toast->message->message;
                        // array_push($toasts_arry, $create_user_toast);
                        $toasts_arry['create user'] = $create_user_toast;
                    }
                }

                $data = array(
                    'toasts_arry' => $toasts_arry
                );
            }
    
                echo json_encode($data);
        }

        // update toast in toasts table after message/position has been changed
        public function updateToast(Request $request) {
            if($request->ajax()) {
                $setting = $request->get('setting');
                $value = $request->get('value');
                $title = $request->get('toast');

                $toast = Toast::where('title', $title)->first();


                if($setting == 'position_id') {
                    $toast->position_id = $value;
                } else if($setting == 'message_id') {
                    $toast->message_id = $value;
                }

                $toast->save();



                $data = array(
                    'setting' => $setting,
                    'value' => $value,
                    'toast' => $toast,
                );

                echo json_encode($data);
            }
        }

    
        // get all toasts, messages and positions from toasts table, messages table, and positions table
        public function getAllToastData(Request $request) {
            if($request->ajax()) {
                $toasts = Toast::all();
                $toasts_array = [];
                $messages = Message::all();
                $messages_array = [];

                $positions = Position::all();  
                $positions_array = [];  
                
                foreach($toasts as $toast) {
                    $toast['message'] = $toast->message->message;
                    $toast['position'] = $toast->position->name;
                    array_push($toasts_array, $toast);
                }

                foreach($messages as $message) {
                    array_push($messages_array, $message['message']);
                }

                foreach($positions as $position) {
                    array_push($positions_array, $position['name']);
                }

                $data = array(
                    'toasts' => $toasts_array,
                    'messages' => $messages,
                    'messages_array' => $messages_array,
                    'positions' => $positions,
                    'positions_array' => $positions_array,
                );
            }
    
                echo json_encode($data);
        }


        // add new message to messages table
        public function addNewToastMessage(Request $request) {
            if($request->ajax()) {
                $new_message = $request->get('message');

                $message = new Message;
                $message->message = $new_message;
                $message->save();
            }
    
            // echo json_encode($data);
        }


   /**
    * =============================================================================== 
    * Admin Settings - General System Configurations
    * ===============================================================================
    */

        // add new email to digestEmail table
        public function addDigestEmail(Request $request) {
            if($request->ajax()) {
                $query = $request->get('email');

                $email = new DigestEmail;
                $email->email = $query;
                $email->save();

                $data = array(
                    'email' => $query,
                );

                session()->flash('new-digest-email-created-message', 'new email was added');
                echo json_encode($data);
            } 
        }

        // get all emails from digestEmail table to populate 'Select Digest Email'
        public function getDigestEmails(Request $request) {
            if($request->ajax()) {
                $digest_emails = DigestEmail::all();
                $cron_job_email = CronJobDigest::first()->pluck('digest_email_id');
                $digest_emails_arry = [];



                foreach($digest_emails as $email) {
                    // array_push($digest_emails_arry, $email['email']);
                    $digest_emails_arry[$email['id']] = $email['email'];
                }

                $data = array(
                    'digest_emails' => $digest_emails,
                    'cron_job_email' => $cron_job_email,
                    'digest_emails_arry' => $digest_emails_arry,
                );
        
                echo json_encode($data);
            } 
        }


        // update the cron_job_digest table
        public function updateCronJobDigest(Request $request) {
            if($request->ajax()) {
                $email_id = $request->get('email_id');
                $time = $request->get('time');
            
                $cron_job = CronJobDigest::first();
                if(!empty($email_id)) {
                    $cron_job->digest_email_id = $email_id;
                }
                if(!empty($time)) {
                    $cron_job->time = $time;
                }

                $cron_job->save();

                $data = array(
                    // 'digest_emails' => $digest_emails,
                    // 'cron_job_email' => $cron_job_email,
                    // 'digest_emails_arry' => $digest_emails_arry,
                );
        
                echo json_encode($data);
            } 
        }


        // get number_displayed from display_posts table
        public function getNumPostsDisplayed(Request $request) {
            if($request->ajax()) {
                
                $num_of_posts_query = DisplayPost::first();
                $num_of_posts = $num_of_posts_query['number_displayed'];
                $max_num_of_posts = $num_of_posts_query['max_number'];

                $data = array(
                    'num_of_posts' => $num_of_posts,
                    'max_num_of_posts' => $max_num_of_posts,
                );
        
                echo json_encode($data);
            } 
        }



        // update number_displayed in display_posts table
        public function updateNumDisplayed(Request $request) {
            if($request->ajax()) {
                $num = $request->get('num');

            
                $display_posts = DisplayPost::first();
                $display_posts->number_displayed = $num;
                $display_posts->save();

                $data = array(
                    // 'digest_emails' => $digest_emails,
                    // 'cron_job_email' => $cron_job_email,
                    // 'digest_emails_arry' => $digest_emails_arry,
                );
        
                echo json_encode($data);
            } 
        }



        // delete user from users table
        public function deleteUser(Request $request) {
            if($request->ajax()) {
                $user_id = $request->get('user_id');

            
                $user = User::findOrFail($user_id);

                // returns bool whether user was deleted
                $user_deleted = $user->delete();

                $data = array(
                    // 'digest_emails' => $digest_emails,
                    // 'cron_job_email' => $cron_job_email,
                    'user_deleted' => $user_deleted,
                );
        
                echo json_encode($data);
            } 
        }
        
    
}



