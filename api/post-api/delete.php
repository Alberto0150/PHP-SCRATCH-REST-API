<?php
    // Add headers for public API 
    header('Access-Control-Allow-Origin: *');
    // add value of content-type
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With'); 
    //X-Requested-With is for helping with cross-site scripting attacks, core, etc.
  
    // bring in db
    include_once '../../config/Database.php';

    // bring in models
    include_once '../../models/Post.php';

    // Instantiate DB and Connect to it
    $database = new Database();
    $db = $database->connect();

    // Instantiate Post Object
    $post = new Post($db);

    //  Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $post->id = $data->id;

    // Delete Post
    if($post->delete()){
        echo json_encode(
            array('message' => 'Post Deleted'
        ));
    }else{
        echo json_encode(
            array('message' => 'Post Not Deleted'
        ));
    }

?>