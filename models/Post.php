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

        // Get only 1 specific post
        public function single_post(){
            $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at 
            FROM '.$this->table.' p 
            LEFT JOIN 
            categories c ON p.category_id = c.id
            WHERE p.id = ? 
            LIMIT 0,1';

            // prepare statement
            $statement = $this->connection->prepare($query);

            // Bind ID
            $statement->bindParam(1, $this->id);

            // execute query
            $statement->execute();

            // Fetch array to return
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author= $row['author'];
            $this->category_id= $row['category_id'];
            $this->category_name = $row['category_name'];
        }

        // Create Post
        public function create(){
            //  Create query
            //  : to use named parameter in PDO
            $query = 'INSERT INTO '. $this->table . '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';

            // Prepare statement
            $statement = $this->connection->prepare($query);
        
            // Clean Data
            // htmlspecialchars() to prevent any html code special character 
            // strip_tags()) to strip any tags
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            // to binding created query with specific. format: placebolder, what_to_bind
            $statement->bindParam(':title', $this->title);
            $statement->bindParam(':body', $this->body);
            $statement->bindParam(':author', $this->author);
            $statement->bindParam(':category_id', $this->category_id);

            //  Exec query
            if($statement->execute()){
                return true;
            }

            // Print the error if something wrong
            printf("Error: %s. \n", $statement->error);
            return false;
        }

        // Update post
        public function update(){
            //  Create query
            //  : to use named parameter in PDO
            $query = 'UPDATE '. $this->table . '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            WHERE
                id = :id';

            // Prepare statement
            $statement = $this->connection->prepare($query);
        
            // Clean Data
            // htmlspecialchars() to prevent any html code special character 
            // strip_tags()) to strip any tags
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            // to binding created query with specific. format: placebolder, what_to_bind
            $statement->bindParam(':title', $this->title);
            $statement->bindParam(':body', $this->body);
            $statement->bindParam(':author', $this->author);
            $statement->bindParam(':category_id', $this->category_id);
            $statement->bindParam(':id', $this->id);

            //  Exec query
            if($statement->execute()){
                return true;
            }

            // Print the error if something wrong
            printf("Error: %s. \n", $statement->error);
            return false;
        }

        // Delete post
        public function delete() {
            //  Create query
            //  : to use named parameter in PDO
            $query = 'DELETE FROM '. $this->table . '
            WHERE
                id = :id';

            // Prepare statement
            $statement = $this->connection->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $statement->bindParam(':id', $this->id);

            //  Exec query
            if($statement->execute()){
                return true;
            }

            // Print the error if something wrong
            printf("Error: %s. \n", $statement->error);
            return false;
        }
    }
?>