<?php


//-- Connection to DB --//

$servername = "wgappsdevweb.kennesaw.edu";
$username = "jspark10";
$password = "Jir3Shroigjov+";
$database = "ksutoday";

// data source name
$dsn = "mysql:host=$servername;dbname=$database";


try{
    // the PDO construct needs: 1) DSN, 2) username, 3) password
    $db_connection = new PDO($dsn, $username, $password);
} catch(Exception $e) {
    echo 'there was an error connecting to db: ' . $e->getMessage();
}




//-- Set db data to variables --//

try{
    
    //-- Get posts
    $posts_query = "SELECT * FROM posts WHERE post_state='Publish'";
    $posts_results = $db_connection->query($posts_query);

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

} catch(Exception $e) {
    echo 'Could not fetch posts, categories, or topics: ' . $e->getMessage();
}