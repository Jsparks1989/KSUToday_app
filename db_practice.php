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









?>