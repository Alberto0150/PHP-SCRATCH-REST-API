<?php
    class Post{
        // DB stuff
        private $connection;
        private $table = 'posts';

        // Post Properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // DB Constructor
        // a method within function within a class, run automatically when initiate the class
        public function __construct($db)
        {
            $this->connection = $db;
        }

        // Get Posts
        public function read(){
            // create query
            $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at 
            FROM '.$this->table. ' p 
            LEFT JOIN categories c
            ON p.category_id = c.id
            ORDER BY p.created_at DESC';

            // prepare statement
            $statement = $this->connection->prepare($query);

            // execute query
            $statement->execute();

            return $statement;

        }
    }
?>