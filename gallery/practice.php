<?php

class Database{

    public $connection;

    function __construct(){
        $this->open_db_connection();
    }

    public function open_db_connection(){
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($this->connection->connect_errno){
            die("Database connectioin failed" . $this->connection->connect_error);
        }
    }

    public function query($sql){
        $result = $this->connection->query($sql);
        $this->confirm_query($result);
        return $result;  //MAKE SURE TO RETURN THE RESULT!
    }

    private function confirm_query($result){
        if(!$result){
            die("Query failed :(" . $this->connection->error);
        }
    }

    public function escape_string($string){
        $escape_string = $this->connection->real_escape_string($string);
        return $escape_string;
    }

    public function the_insert_id(){
        return $this->connection->insert_id;
    }
}

$database = new Database();   // INSTANCIATE! THEN WE CAN USE THIS INSTANTCE ANYWHERE IN THE PROGRAM



$result = $database->query("SELECT * FROM users WHERE id=1");
$user_found = mysqli_fetch_array($result);
echo $user_found["username"];

?>