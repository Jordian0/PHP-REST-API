<?php

use OpenApi\Annotations as OA;

error_reporting(E_ALL);
ini_set('display_error', 1);

/**
 * @OA\Info(title="PDO REST API", version="1.0")
 */

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
    /**
     * @OA\Get(
     *     path="/restapi_php/api/post/all_posts.php",
     *     summary="Gets all posts",
     *     tags={"Posts"},
     *     @OA\Response(resposne="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
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
    /**
     * @OA\Get(
     *     path="/restapi_php/api/post/single_post.php",
     *     summary="Method to read a single post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="The id passed to get data like in query string",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(resposne="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
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
    /**
     * @OA\Post(
     *     path="/restapi_php/api/post/insert_data.php",
     *     summary="Method to insert a post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="body",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="category_id",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="author",
     *                     type="string",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(resposne="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
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
            return false;
        }
    }


    // Method to update the records
    /**
     * @OA\Put(
     *     path="/restapi_php/api/post/update.php",
     *     summary="Method to update a post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                  ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="body",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="category_id",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="author",
     *                     type="string",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(resposne="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function update($params) {
        try {
            // assigning values
            $this->id = $params['id'];
            $this->title = $params['title'];
            $this->body = $params['body'];
            $this->category_id = $params['category_id'];
            $this->author = $params['author'];

            // Query for updating existing record.
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
            return false;
        }
    }


    // Method to delete post from database
    /**
     * @OA\Delete(
     *     path="/restapi_php/api/post/destroy_post.php",
     *     summary="Method to destroy a post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(resposne="200", description="An example resource"),
     *     @OA\Response(response="404", description="Not Found")
     * )
     */
    public function destroy_post($id) {
        try {
            // assigning values
            $this->id = $id;

            // Query for updating existing record.
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
            return false;
        }
    }

}
