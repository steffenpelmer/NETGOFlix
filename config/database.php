<?php
    class Database
    {
        // Parameter
        private $host = 'localhost';
        private $dbName = 'netgoflix';
        private $username = 'admin';
        private $password = 'admin';

        // Verbindung aufbauen
        public function connect() 
        {
            $this->conn = null;
            
            try 
            {
                $this->conn = new PDO('mysql:host=' .$this->host. ';dbname=' .$this->dbName, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) 
            {
                echo 'Connection Error: '. $e->getMessage();
            }

            return $this->conn;
        }
    }
?>