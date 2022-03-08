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

    // Get ID from URL
    //  isset() check if parameter is set
    // $_GET[] is use to get super global (get something from url parameter)
    // ? = then
    // : = else
    $post->id = isset($_GET['id']) ? $_GET['id'] : die() ;

    // querying post 
    $result = $post->single_post();

    //  Create array
    $post_arr = array(
        'id' => $post->id,
        'title'=> $post->title,
        'body'=> $post->body,
        'author'=> $post->author,
        'category_id'=> $post->category_id,
        'category_name' => $post->category_name
    );

    // Make JSON
    // print_r() is to print an array
    print_r(json_encode($post_arr));
?>