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
$posts_query = "SELECT * FROM posts";
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
