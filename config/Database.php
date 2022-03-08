<?php
     class Database {
        //  DB param
        private $host ='localhost';
        private $db_name = 'myblog';
        private $username = 'root';
        private $password = '';
        private $connection ;

        // DB connection
        public function connect(){
            // set connection to null 
            $this->connection = null;

            // connect through PDO, so need new PDO object
            try{
                $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,$this->username,$this->password);

                // set  error mode, in case something goes wrong
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOexception $e){
                // if goes wrong
                echo ' Connection Error:'. $e->getMessage();
            }

            return $this->connection;
        }
    }
?>