#!/opt/rh/rh-php72/root/usr/bin/php

<?php


/**
 * =================================================================================================================================== 
 * DB Configurations
 * ===================================================================================================================================
 */ 


$servername = "wgappsdevweb.kennesaw.edu";
$username = "jspark10";
$password = "Jir3Shroigjov+";
$database = "ksutoday";



// data source name
$dsn = "mysql:host=$servername;dbname=$database";

// the PDO construct needs: 1) DSN, 2) username, 3) password
$db_connection = new PDO($dsn, $username, $password);

//-- Get posts
// $posts_query = "SELECT * FROM posts WHERE post_state='Published'";
$posts_query = "SELECT * FROM posts WHERE NOT DATE(updated_at) = CURDATE() AND post_state='Publish'";
$posts_results = $db_connection->query($posts_query);

$email_id = "SELECT digest_emil_id FROM cron_job_digests WHERE id='1'";
$email_id_result = $db_connection->query($email_id);

print_r($email_id_result);


$digest_email = "SELECT email FROM digest_emails WHERE id=$email_id_result";

echo 'hwllo';
// Get Posts
$posts = [];
foreach($posts_results as $post) {
    array_push($posts, $post);
}


//-- Get categories
$categories_query = "SELECT * FROM categories";
$categories_results = $db_connection->query($categories_query);

$categories = [];
foreach($categories_results as $category) {
    array_push($categories, $category);
}


//-- Get topics
$topics_query = "SELECT * FROM topics";
$topics_results = $db_connection->query($topics_query);

$topics = [];
foreach($topics_results as $topic) {
    array_push($topics, $topic);
}










//-- Get the id of the email used in cron job
$email_id_query = "SELECT digest_email_id FROM cron_job_digests LIMIT 1";
$email_id_result = $db_connection->query($email_id_query)->fetch();

$digest_email = $email_id_result['digest_email_id'];

//-- use the id gotten from cron job to get the email from digest_email
$digest_email = "SELECT email FROM digest_emails WHERE id=$email_id_result LIMIT 1";
$digest_email_result = $db_connection->query($digest_email)->fetch();








/**
 * =================================================================================================================================== 
 * ===================================================================================================================================
 */ 




// if(count($posts) > 0){




    // $to_email_address = 'jspark10@kennesaw.edu';
    $to_email_address = 'justinaws01@gmail.com';
    $subject = 'KSUToday Digest from ksutodaytest';

    $headers = "From: justin@email.com" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


    /**
     * Add href links to all spots in digest
    */



    $message = '<!DOCTYPE html>';
    $message .= '<html lang="en">';
    $message .= '<head>';
    $message .= '<meta charset="UTF-8">';
    $message .= '<title>KSU Today Digest</title>';
    //-- <style>
    $message .= '<style>
    body {margin: 0; font-family: Arial, sans-serif; font-size: 1em;}
    a {color: #007A95;}
    a:hover {text-decoration: none;}
    /*#wrapper {max-width: 700px; margin: 0 auto;}*/

    #header {background: black; color: white; font-family: Palatino, serif; width: 95%; padding: 10px 2.5%;}
    #header img {width: 300px;}
    #header h1 { display: inline-block; margin: 0; padding: 0; font-weight: normal; position: relative; top: -7px;}

    #gold_bar {background: #febc11; width: 95%; padding: 5px 2.5%;}
    #gold_bar span {margin: 0;}

    .card {border: 1px solid #888; border-top: 5px solid black; width: 87%; margin: 0 2.5%; padding: 0 4%;  margin-bottom: 10px; background: white;}
    .card h3 {margin-bottom: 0;}
    .card .attribution {margin: 0; padding: 0; font-size: 0.85em;}
    .tag {background: black; padding: .3em .7em; padding-bottom: .5em; text-decoration: none; color: white; border-radius: .7em; display: inline-block; margin: 2.5px 0; font-size: 0.85em;}
    .tag:hover {background: #797979;}
    .tag.alt {background: #febc11; color: black;}
    .tag.alt:hover {background: #ffd975;}

    #digest_list {width: 95%; padding: 10px 2.5%;}

    .category_group {background: #e5e5e5; width: 95%; padding: 20px 2.5%; margin-bottom: 40px; /*border-top: 5px solid #007A95;*/}
    .category_group > h2 {margin-top: 0; font-size: 1.8em;}
    </style>';
    //-- </style>
    $message .= '</head>';
    //-- <body>
    $message .= '<body>';
    $message .= '<div id="wrapper">';
    $message .= '<div id="header">';
    $message .= '<img src="http://artoo.kennesaw.edu/_resources/images/global/logo.png" alt="">';
    $message .= '<h1>Faculty Inform</h1>';
    $message .= '</div>';
    $message .= '<div id="gold_bar"><span>Digest Posts for ' . date("F j, Y") . '</span></div>';
    $message .= '<div id="body">';
    //-- Loop through categories | line 102
    // foreach($categories as $category){
    //     $message .= '<div id="digest_list">';
    //     $message .= '<h2>' . $category['name'] . '</h2><ul>';
    //     foreach($posts as $post){
    //         if($post['category_id'] == $category['id']){
    //             $message .= '<li><a href="">' . $post['title'] . '</a></li>';
    //         }
    //     }
    //     $message .= '</ul></div>';
    // // End of foreach loop | line 120
    // }



    //-- Line 126
    // foreach($categories as $category){
    //     $message .= '<div class="category_group">';
    //     $message .= '<h2>' . $category['name'] . '</h2>';
    //     foreach($posts as $post){
    //         if($post['category_id'] == $category['id']){
    //             $message .= '<div class="card">';
    //             $message .= '<h3>' . $post['title'] . '</h3>';
    //             $message .= '<p class="attribution">' . $post['from_account'] . '</p>';
    //             $message .= '<p>' . $post['summary'] . '</p>';
    //             //-- Line 150
    //             $message .= '<p>';
    //             foreach($topics as $topic){
    //                 if($post['topic_id'] == $topic['id']){
    //                     $message .= '<a href="#" class="tag">' . $topic['name'] . '</a>';
    //                 }
    //             }
    //             //-- Line 159
    //             $message .= '</p>';
    //             $message .= '<p><a href="">Read More</a></p>';
    //             $message .= '</div><!-- /card -->';
    //         }
    //     }
    //     $message .= '</div><!-- /category_group -->';
    // }
    $message .= '</div><!-- /body -->';
    $message .= '</div><!-- /wrapper -->';
    $message .= '</body>';
    $message .= '</html>';


    mail("justinaws01@gmail.com","KSU Today Digest send_email",$message, $headers);



// } else {






    


    // $message = 'No posts from ksutodaytest send_email';
    // $subject = 'No Posts from ksutodaytest';
    // // $to_email_address = 'jspark10@kennesaw.edu';
    // $to_email_address = 'justinaws01@gmail.com';
    // $headers = "From: justin@email.com" . "\r\n";
    // $headers .= "MIME-Version: 1.0" . "\r\n";
    // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";



    // mail("justinaws01@gmail.com", $subject, $message);
    // mail("justinaws01@gmail.com", $digest_email, $digest_email_result['email']);



// }


?>