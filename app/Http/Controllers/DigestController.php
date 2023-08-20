<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;


class DigestController extends Controller
{
    //
    public function index() {
        return view('moderator.moderator-index');
    }

    public function showPost(Post $post) {

        return view('digest.digest-post', ['post' => $post]);
    }
    
}
