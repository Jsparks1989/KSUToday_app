<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    //
    public function downloadFile($id) {
        $post = Post::findOrFail($id);
        $post_file = $post->file_attach;
        // $dl_file = substr($post_file, 12);
        // echo 'file: ' . $dl_file;


        // //-- get the file
        // $file = Storage::get('the_file.docx');

        // //-- download the file 
        return Storage::download($post_file);
    }

    public function showFile($id) {
        $post = Post::findOrFail($id);
        $post_file = $post->file_attach;

        $file_name = str_replace("file_attach/", "", $post->file_attach);

        //-- get the file
        return Storage::get($post_file);
    }
    
}
