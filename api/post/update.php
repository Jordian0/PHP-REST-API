<?php

error_reporting(E_ALL);
ini_set('display_error', 1);

// Headers
Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

// Including required files.
include_once('../../config/Database.php');
include_once('../../models/Post.php');

// Connecting with database.
$database = new Database;
$db = $database->connect();

$post = new Post($db);
$data = json_decode(file_get_contents("php://input"));          // for raw object data

if(isset($data)) {

    // updating new post from user input.
    $params = [
        'id' => $data->id,
        'title' => $data->title,
        'body' => $data->body,
        'category_id' => $data->category_id,
        'author' => $data->author,
    ];

    if($post->update($params)) {
        echo json_encode(['message'=>'Data updated successfully!']);
    }

}

