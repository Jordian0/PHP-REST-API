<?php

error_reporting(E_ALL);
ini_set('display_error', 1);

// class for posts table
class Post {

    // Post Properties
    public $id;
    public $category_id;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Database Data
    private $connection;
    private $table = 'posts';


    // constructor
    public function __construct($db) {
        $this->connection = $db;
    }

    // Method to read all the saved posts from database
    public function readPosts() {
        // Query for reading posts table
        $query = 'SELECT 
            categories.name as categories,
            posts.id,
            posts.category_id,
            posts.title,
            posts.body,
            posts.author,
            posts.created_at
            FROM '.$this->table.' posts LEFT JOIN
            categories ON posts.category_id = categories.id
            ORDER BY 
            posts.created_at DESC
        ';

        $post = $this->connection->prepare($query);
        $post->execute();

        return $post;
    }


    // Method to read one single post
    public function read_single_post($id) {
        $this->id = $id;

        // Query for reading a post table
        $query = 'SELECT 
            categories.name as categories,
            posts.id,
            posts.category_id,
            posts.title,
            posts.body,
            posts.author,
            posts.created_at
            FROM '.$this->table.' posts LEFT JOIN
            categories ON posts.category_id = categories.id
            WHERE posts.id=?
            LIMIT 0,1
        ';

        $post = $this->connection->prepare($query);
        $post->bindValue(1, $this->id, PDO::PARAM_INT);
//        $post->execute([$this->id]);

        $post->execute();

        return $post;
    }
}
