<?php
    // Add headers for public API 
    header('Access-Control-Allow-Origin: *');
    // add value of content-type
    header('Content-Type: application/json');
  
    // bring in db
    include_once '../../config/Database.php';

    // bring in models
    include_once '../../models/Post.php';

    // Instantiate DB and Connect to it
    $database = new Database();
    $db = $database->connect();

    // Instantiate Post Object
    $post = new Post($db);

    // querying post 
    $result = $post->read();

    // get row count
    $num = $result->rowCount();

    // check if there is any post
    if($num > 0)
    {
        $post_arr = array();

        // set for actual data go
        $post_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $post_item = array(
                'id' => $id,
                'title'=> $title,
                'body'=> html_entity_decode($body),
                'author'=> $author,
                'category_id'=> $category_id,
                'category_name' => $category_name
            );

            // Push to "data"
            array_push($post_arr['data'], $post_item);
        }

        // Turn into JSON & output
        echo json_encode($post_arr);
    }
    else{
        // No posts
        echo json_encode(array('message'=>'no posts found'));
    }
?>