#!/opt/rh/rh-php72/root/usr/bin/php

<?php

/*

    Send digest to me and kevin the digest @ 12 everyday

*/

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
        $posts_query = "SELECT * FROM posts WHERE NOT DATE(updated_at) = CURDATE() AND post_state='Publish'";
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




        //-- Add topic name to each $post
        foreach($posts as $post) {
            foreach($topics as $topic) {
                if($topic['id'] == $post['topic_id']) {
                    $post['topic_name'] = $topic['name'];
                }
            }
        }





        //-- Get the id of the email used in cron job
        $email_id_query = "SELECT digest_email_id FROM cron_job_digests LIMIT 1";
        $email_id_result = $db_connection->query($email_id_query)->fetch();

        //-- The id for email in digest_emails table
        $digest_email_id = $email_id_result['digest_email_id'];

        //-- use the id gotten from cron job to get the email from digest_email
        $digest_email = "SELECT email FROM digest_emails WHERE id=$digest_email_id LIMIT 1";
        $digest_email_result = $db_connection->query($digest_email)->fetch();

        //-- The email to send digest to
        $destination_email = $digest_email_result['email'];


    /**
     * =================================================================================================================================== 
     * 
     * ===================================================================================================================================
     */ 


        if(count($posts) > 0){
            // $to_email_address = 'jspark10@kennesaw.edu';
            $to_email_address = 'justinaws01@gmail.com, jspark10@kennesaw.edu, kball5@kennesaw.edu';
            // $linux_team = $destination_email;
            $subject = 'KSUToday Digest';

            $headers = "From: test@email.com" . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


            /**
             * Add href links to all spots in digest
            */

            $link_read_posts = "https://ksutodaytest.kennesaw.edu/read-posts/";
            // $link = "https://ksutodaytest.kennesaw.edu/post/";
            $link = "https://ksutodaytest.kennesaw.edu/digest/";

            $message = '<!DOCTYPE html>';
            // $message .= '<html lang="en">';
            $message .= '<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">';
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
            $message .= '<body style="margin:0;font-family:Arial,sans-serif;font-size:1em;">';
            $message .= '<div id="wrapper">';
            $message .= '<div id="header" style="background: black; color: white; font-family: Palatino, serif; width: 95%; padding: 10px 2.5%;">';
            $message .= '<img src="http://artoo.kennesaw.edu/_resources/images/global/logo.png" alt=""style="width:300px;">';
            $message .= '<h1 style="display: inline-block; margin: 0; padding: 0; font-weight: normal; position: relative; top: -7px;">Faculty Inform</h1>';
            $message .= '</div>';
            $message .= '<div id="gold_bar" style="background: #febc11; width: 95%; padding:5px 2.5%;"><span style="margin: 0;">Digest Posts for ' . date("F j, Y") . '</span></div>';
            $message .= '<div id="body">';
            //-- Loop through categories | line 102
            foreach($categories as $category){
                $message .= '<div style="width:95%; padding:10px 2.5%;">';
                $message .= '<h2>' . $category['name'] . '</h2><ul>';
                foreach($posts as $post){
                    if($post['category_id'] == $category['id']){

                        $message .= '<li><!--[if mso]>
                                    <v:rect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:40px;v-text-anchor:middle;width:200px;" stroke="f" fillcolor="#556270">
                                    <w:anchorlock/>
                                    <center>
                                    <![endif]-->
                                    <a href=';
                        $message .= $link;
                        $message .= $post['id'];
                        $message .= ' style="color: #007A95;">';
                        $message .= $post['title'];
                        $message .= '</a>
                                    <!--[if mso]>
                                    </center>
                                    </v:rect>
                                    <![endif]--></li>';
                    }
                }
                $message .= '</ul></div>';
            // End of foreach loop | line 120
            }

            //-- Line 126
            foreach($categories as $category){
                $message .= '<div class="category_group" style="background:#e5e5e5;width:95%;padding:20px 2.5%;margin-bottom:40px;">';
                $message .= '<h2 style="margin-top:0;font-size:1.8em;">' . $category['name'] . '</h2>';
                foreach($posts as $post){
                    if($post['category_id'] === $category['id']){
                        $message .= '<div style="border: 1px solid #888; border-top: 5px solid black; width: 87%; margin: 0 2.5%; padding: 0 4%;  margin-bottom: 10px; background: white;">';
                        $message .= '<h3 style="margin-bottom: 0;">' . $post['title'] . '</h3>';
                        $message .= '<p class="attribution" style="margin: 0; padding: 0; font-size: 0.85em;">Posted by: ' . $post['from_account'] . '</p>';
                        $message .= '<p>' . $post['summary'] . '</p>';
                        //-- Line 150


                        $message .= '<p>';
                        foreach($topics as $topic){
                            if($post['topic_id'] == $topic['id']){
                                $message .= '<!--[if mso]>
                                            <v:rect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:40px;v-text-anchor:middle;width:200px;" stroke="f" fillcolor="#556270">
                                            <w:anchorlock/>
                                            <center>
                                            <![endif]-->';
                                // $message .= '<a href='.$link_read_posts.' class="tag" style="background: black; padding: .3em .7em; padding-bottom: .5em; text-decoration: none; color: white; border-radius: .7em; display: inline-block; margin: 2.5px 0; font-size: 0.85em;">' . $topic['name'] .'</a>';
                                $message .= '<span style="background: black; padding: .3em .7em; padding-bottom: .5em; text-decoration: none; color: white; border-radius: .7em; display: inline-block; margin: 2.5px 0; font-size: 0.85em;">' . $topic['name'] .'</span>';
                                $message .= '<!--[if mso]>
                                            </center>
                                            </v:rect>
                                            <![endif]-->';
                            }
                        }
                        $message .= '</p>';


                        // =======================================================================================================================================



                        $message .= '<p><!--[if mso]>
                                    <v:rect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:40px;v-text-anchor:middle;width:200px;" stroke="f" fillcolor="#556270">
                                    <w:anchorlock/>
                                    <center>
                                    <![endif]-->

                                    <a href=';
                        $message .= $link;
                        $message .= $post['id'];
                        $message .= ' style="color: #007A95;">';
                        $message .= 'Read More';
                        $message .= '</a>

                                    <!--[if mso]>
                                    </center>
                                    </v:rect>
                                    <![endif]--></p>';

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
            //--  COMMENT OUT THE ELSE {} PORTION - WILL NOT BE SENDING OUT EMAIL IF THERE ARE NO POSTS SET TO PUBLISH --//
            $message = 'No posts from ksutodaytest';
            $subject = 'test_email';
            // $subject = $digest_email_id;
            // $message = $digest_email_result['email'];
            // $linux_team = $destination_email;
            $headers = "From: justin@email.com" . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail("justinaws01@gmail.com, jspark10@kennesaw.edu, kball5@kennesaw.edu", $subject, $message);
            // mail("justinaws01@gmail.com", $email_id_result, $digest_email_result);
        }

?>