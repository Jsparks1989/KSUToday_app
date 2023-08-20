
<?php

public function liveSearchMyPosts(Request $request) {

$query = $request->get('query');
$POSTpage = $request->get('page');
$user = Auth::user()->id;

$limit = '10';
$page = 1;
if($POSTpage > 1) {
    $start = (($POSTpage - 1) * $limit);
    $page = $POSTpage;
} else {
    $start = 0;
}

//-- Get All Posts based on input
if($query != '' && $query != null) {
  // $data = Post::where('user_id', 'like', '%' .$query['user_id']. '%')
  $data = User::findOrFail($user)->posts()
  ->where('title', 'like', '%' .$query['search_my_posts']. '%')
  // ->orWhere('summary', 'like', '%' .$query['search_my_posts']. '%')
  ->orWhere(function($q) use($query){
      $q->where('user_id', 'like', '%' .$query['user_id']. '%')
        ->where('summary', 'like', '%' . $query['search_my_posts'] . '%');
  })
  ->get();
} else {
  // $data = User::findOrFail($user)->posts()
  $data = Post::where('user_id', 'like', '%' .$user. '%')
      ->orderBy('created_at', 'desc')->skip($start)->take($limit)->get();
}
$total_data = $data->count();







//-- Get Posts based on page chosen in pagination
$filter_data = User::findOrFail($user)->posts()
->where('title', 'like', '%' .$query['search_my_posts']. '%')
->orWhere(function($q) use($query){
    $q->where('user_id', 'like', '%' .$query['user_id']. '%')
      ->where('summary', 'like', '%' . $query['search_my_posts'] . '%');
})->skip($start)->take($limit)->get();
$total_filter_data = count($filter_data);



$output = '
<label>Total Records - '.$total_data.'</label><ul class="read-post-list">
';

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
        $output .= '<div class="post-list-created-at"><p><em>'.$row->created_at.'</em></p></div>';
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

$output .= '
  </ul>
      <br />
      <div align="center">
      <ul class="pagination">
  ';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';



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
            <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
        </li>
        ';

        $previous_id = $page_array[$count] - 1;
        if($previous_id > 0) {
            $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
        } else {
            $previous_link = '
            <li class="page-item disabled">
            <a class="page-link" href="#">Previous</a>
            </li>
            ';
        }
        $next_id = $page_array[$count] + 1;
        if($next_id >= $total_links) {
            $next_link = '
            <li class="page-item disabled">
            <a class="page-link" href="#">Next</a>
            </li>
            ';
        } else {
            $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
        }
    } else {
        if($page_array[$count] == '...') {
            $page_link .= '
            <li class="page-item disabled">
                <a class="page-link" href="#">...</a>
            </li>
            ';
        } else {
            $page_link .= '
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
            ';
        }
    }
}

$output .= $previous_link . $page_link . $next_link;
$output .= '</ul></div>';

echo $output;



    
} // live search pagination end