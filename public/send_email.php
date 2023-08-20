<?php

// require_once('email_template.php');

require_once('db_config.php');

// mail($to_email_address, $subject, $message, [$headers], [$parameters]);

$to_email_address = 'justinaws01@gmail.com';
$subject = 'KSUToday Digest';

$headers = "From: justin@emal.com" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";






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
foreach($categories as $category){
    $message .= '<div id="digest_list">';
    $message .= '<h2>' . $category['name'] . '</h2><ul>';
    foreach($posts as $post){
        if($post['category_id'] == $category['id']){
            $message .= '<li><a href="">' . $post['title'] . '</a></li>';
        }
    }
    $message .= '</ul></div>';
// End of foreach loop | line 120
}



//-- Line 126
foreach($categories as $category){
    $message .= '<div class="category_group">';
    $message .= '<h2>' . $category['name'] . '</h2>';
    foreach($posts as $post){
        if($post['category_id'] == $category['id']){
            $message .= '<div class="card">';
            $message .= '<h3>' . $post['title'] . '</h3>';
            $message .= '<p class="attribution">' . $post['from_account'] . '</p>';
            $message .= '<p>' . $post['summary'] . '</p>';
            //-- Line 150
            $message .= '<p>';
            foreach($topics as $topic){
                if($post['topic_id'] == $topic['id']){
                    $message .= '<a href="#" class="tag">' . $topic['name'] . '</a>';
                }
            }
            //-- Line 159
            $message .= '</p>';
            $message .= '<p><a href="">Read More</a></p>';
            $message .= '</div><!-- /card -->';
        }
    }
    $message .= '</div><!-- /category_group -->';
}
$message .= '</div><!-- /body -->';
$message .= '</div><!-- /wrapper -->';
$message .= '</body>';
$message .= '</html>';


mail($to_email_address, $subject, $message, $headers);
echo $message;





// UPDATE posts SET post_state='Published' WHERE id=(loop through $posts[id])
foreach($posts as $post) {
    $post_id = $post['id'];
    $update_posts_query = "UPDATE posts SET post_state='Published' WHERE id=$post_id";
    $db_connection->query($update_posts_query);
}





//-- Close db connection
$db_connection = NULL;
