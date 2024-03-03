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
//        $post->bindValue('id', $this->id, PDO:PARAM_INT);
//        $post->execute([$this->id]);

        $post->bindValue(1  , $this->id, PDO::PARAM_INT);       // first one is order of ?
        $post->execute();

        return $post;
    }


    // Method to create new records
    public function create_new($params) {
        try {
            // Assigning values
            $this->title = $params['title'];
            $this->body = $params['body'];
            $this->category_id = $params['category_id'];
            $this->author = $params['author'];

            // Query to store new post in database
            $query = 'INSERT INTO '.$this->table.' 
                SET
                title=:title,
                category_id=:category_id,
                body=:body,
                author=:author
            ';

            $post = $this->connection->prepare($query);

            // binding values
            $post->bindValue('title', $this->title, PDO::PARAM_STR);
            $post->bindValue('body', $this->body, PDO::PARAM_STR);
            $post->bindValue('category_id', $this->category_id, PDO::PARAM_INT);
            $post->bindValue('author', $this->author, PDO::PARAM_STR);

            // executing
            if($post->execute()) {
                return true;
            }

            return false;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    // Method to update the records
    public function update($params) {
        try {
            // assigning values
            $this->id = $params['id'];
            $this->title = $params['title'];
            $this->body = $params['body'];
            $this->category_id = $params['category_id'];
            $this->author = $params['author'];

            // Query for updating exisiting record.
            $query = 'UPDATE '.$this->table.
                ' SET 
                title=:title,
                category_id=:category_id,
                body=:body,
                author=:author 
                WHERE id=:id      
            ';

            $post = $this->connection->prepare($query);

            // binding values
            $post->bindValue('id', $this->id, PDO::PARAM_INT);
            $post->bindValue('title', $this->title, PDO::PARAM_STR);
            $post->bindValue('body', $this->body, PDO::PARAM_STR);
            $post->bindValue('category_id', $this->category_id, PDO::PARAM_INT);
            $post->bindValue('author', $this->author, PDO::PARAM_STR);

            // executing query
            if($post->execute()) {
                return true;
            }

            return false;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    // Method to delete post from database
    public function destroy_post($id) {
        try {
            // assigning values
            $this->id = $id;

            // Query for updating exisiting record.
            $query = 'DELETE FROM '.$this->table.' 
                WHERE id=:id';

            $post = $this->connection->prepare($query);

            // binding values
            $post->bindValue('id', $this->id, PDO::PARAM_INT);

            // executing query
            if($post->execute()) {
                return true;
            }

            return false;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

}
