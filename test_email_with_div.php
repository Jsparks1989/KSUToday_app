#!/opt/rh/rh-php72/root/usr/bin/php

<?php


/**
 * =================================================================================================================================== 
 * DB Configuration
 * ===================================================================================================================================
 */ 


$servername = "wgappsdevweb.kennesaw.edu";
$username = "jspark10";
$password = "Jir3Shroigjov+";
$database = "ksutoday";



// data source name
$dsn = "mysql:host=$servername;dbname=$database";

// PDO construct PDO(DSN, username, password)
$db_connection = new PDO($dsn, $username, $password);

//-- Query posts & put in array
// $posts_query = "SELECT * FROM posts WHERE NOT DATE(updated_at) = CURDATE() AND post_state='Publish'";
// $posts_query = "SELECT * FROM posts WHERE post_state='Published'";
$posts_results = $db_connection->query($posts_query);
$posts = [];
foreach($posts_results as $post) {
    array_push($posts, $post);
}


//-- Get categories & put in array
$categories_query = "SELECT * FROM categories";
$categories_results = $db_connection->query($categories_query);
$categories = [];
foreach($categories_results as $category) {
    array_push($categories, $category);
}


//-- Get topics & put in array
$topics_query = "SELECT * FROM topics";
$topics_results = $db_connection->query($topics_query);
$topics = [];
foreach($topics_results as $topic) {
    array_push($topics, $topic);
}



/**
 * =================================================================================================================================== 
 * ===================================================================================================================================
 */ 





if(count($posts) > 0){
    $to_email_address = 'jspark10@kennesaw.edu';
    // $to_email_address = 'justinaws01@gmail.com';
    $subject = 'KSUToday Digest';

    $headers = "From: test@email.com" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


    /**
     * Add href links to all spots in digest
    */

    $link = "http://ksutodaytest.kennesaw.edu/post/";

    $message = '<!DOCTYPE html>';
    // $message .= '<html lang="en">';
    $message .= '<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office">';
    $message .= '<head>';
    $message .= '<meta charset="UTF-8">';
    // =======================================================================================================
    $message .= '<meta name="viewport" content="width=device-width,initial-scale=1">';
    $message .= '<meta name="x-apple-disable-message-reformatting">';
    $message .= '<!--[if mso]>
                <noscript>
                    <xml>
                        <o:OfficeDocumentSettings>
                            <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                    </xml>
                </noscript>
                <![endif]-->';
    // =======================================================================================================
    $message .= '<title>KSU Today Digest</title>';
    //-- <style>
    //-- $message .= styling for email --//
    //-- </style>
    $message .= '</head>';
    //-- <body>
    $message .= '<body style="margin: 0; font-family: Arial, sans-serif; font-size: 1em;">';
    $message .= '<div id="wrapper">';
    $message .= '<div id="header" style="background: black; color: white; font-family: Palatino, serif; width: 95%; padding: 10px 2.5%;">';
    $message .= '<img src="http://artoo.kennesaw.edu/_resources/images/global/logo.png" alt="" style="width: 300px;">';
    $message .= '<h1 style="display: inline-block; margin: 0; padding: 0; font-weight: normal; position: relative; top: -7px;">Faculty Inform</h1>';
    $message .= '</div>';
    $message .= '<div id="gold_bar" style="background: #febc11; width: 95%; padding: 5px 2.5%;"><span style="margin: 0;">Digest Posts for ' . date("F j, Y") . '</span></div>';
    $message .= '<div id="body">';
    //-- Loop through categories | line 102
    foreach($categories as $category){
        $message .= '<div style="width: 95%; padding: 10px 2.5%;">';
        $message .= '<h2>' . $category['name'] . '</h2><ul>';
        foreach($posts as $post){
            if($post['category_id'] == $category['id']){
                // =======================================================================================================================================
                $message .= '<li style="mso-special-format:bullet;">';
                $message .= '<a href=';
                $message .= $link;
                $message .= $post['id'];
                $message .= ' style="color: #007A95;">';
                $message .= $post['title'];
                $message .= '</a>';
                $message .= '</li>';
                // =======================================================================================================================================
            }
        }
        $message .= '</ul></div>';
    // End of foreach loop | line 120
    }

    //-- Line 126
    foreach($categories as $category){
        $message .= '<div class="category_group" style="background: #e5e5e5; width: 95%; padding: 20px 2.5%; margin-bottom: 40px;">';
        $message .= '<h2 style="margin-top: 0; font-size: 1.8em;">' . $category['name'] . '</h2>';
        foreach($posts as $post){
            if($post['category_id'] === $category['id']){
                $message .= '<div style="border: 1px solid #888; border-top: 5px solid black; width: 87%; margin: 0 2.5%; padding: 0 4%!important;  margin-bottom: 10px; background: white!important;">';
                $message .= '<h3 style="margin-bottom: 0;">' . $post['title'] . '</h3>';
                $message .= '<p class="attribution" style="margin: 0; padding: 0; font-size: 0.85em;">' . $post['from_account'] . '</p>';
                $message .= '<p>' . $post['summary'] . '</p>';
                //-- Line 150
                // $message .= '<p>';
                // foreach($topics as $topic){
                //     if($post['topic_id'] == $topic['id']){
                //         $message .= '<a href="#" class="tag" style="color: #007A95; background: black; padding: .3em .7em; padding-bottom: .5em; text-decoration: none; color: white; border-radius: .7em; display: inline-block; margin: 2.5px 0; font-size: 0.85em;">' . $topic['name'] . '</a>';
                //     }
                // }
                // //-- Line 159
                // $message .= '</p>';
                // =======================================================================================================================================
                // $message .= '<p>'
                // $message .= '<a href=';
                // $message .= $link;
                // $message .= $post['id'];
                // $message .= ' style="color: #007A95;">';
                // $message .= 'Read More';
                // $message .= '</a>';
                // $message .= '</p>';


                $message .= '<p>';
                $message .= '<a href=';
                $message .= $link;
                $message .= $post['id'];
                $message .= ' style="color: #007A95;">';
                $message .= 'Read More';
                $message .= '</a>';
                $message .= '</p>';



                $message .= '</div>';
            }
        }
        $message .= '</div><!-- /category_group -->';
    }
    $message .= '</div><!-- /body -->';
    $message .= '</div><!-- /wrapper -->';
    $message .= '</body>';
    $message .= '</html>';


    mail($to_email_address, $subject, $message, $headers);

    

    // UPDATE posts SET post_state='Published' WHERE id=(loop through $posts[id])
    foreach($posts as $post) {
        $post_id = $post['id'];
        $update_posts_query = "UPDATE posts SET post_state='Published' WHERE id=$post_id";
        $db_connection->query($update_posts_query);
    }
} else {
    $message = 'No posts from ksutodaytest';
    $subject = 'test_email';
    $to_email_address = 'jspark10@kennesaw.edu';
    $headers = "From: justin@email.com" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail("justinaws01@gmail.com", $subject, $message);
}

?>