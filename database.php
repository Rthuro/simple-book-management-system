<?php

    class Database{
        private $host = 'localhost';
        private $name = 'root';
        private $pass = '';
        private $dbname = 'books_db';
        protected $connection;
        
        function connect(){  
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->name, $this->pass);
            return $this->connection;
        }
    }
    
?>