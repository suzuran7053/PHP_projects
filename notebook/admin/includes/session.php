<?php
// CREATE A SESSION CLASS
// IS GOING TO MANAGE LOGIN SYSTEM

class Session {
    private $signed_in = false;
    public $user_id;
    public $message;
    public $count; // to count the number of visitors
    
    // THIS CONSTRUCTOR WORKS AUTOMATICALLY EVERY TIME THE APPLICATION STARTS(=EVERY TIME WE MAKE AN INSTANCE)
    function __construct(){
        // We want session to be available everytime the application is on
        session_start();
        $this->visitor_count(); // Putting here it will start automatically
        $this->check_the_login();
        $this->check_message(); // Everytime we turn on the application, it will always check if there's any $message
    }

    // THIS FUNCTION IS USED TO SHOW SOME MESSAGE 
    // * When we want to show a message after redirecting from other pages, we need this as we can't use variables that were created in other page
            // $session->message("The user has been updated!"); user_edit.php
    // * We can use $message in HTML just like "echo $message;" with class "bg-success", etc    users.php
    public function message($msg = ""){
        if(!empty($msg)){                 // if $msg is not empty
            $_SESSION['message'] = $msg;  // *SETTING // assign the value of $msg to $_SESSION['message']
        } else{                           // if $msg is empty
            return $this->message;        // *GETTING // return message property in this instance
        }
    }

    public function check_message(){
        if(isset($_SESSION['message'])){    // If $_SESSION['message'] is set, assign it into $this->message
            $this->message = $_SESSION['message'];  // And then unset $_SESSION['message']
            unset($_SESSION['message']);
        }else{
            $this->message = "";
        }
    }

 
    public function visitor_count(){
        if(isset($_SESSION['count'])){
            return $this->count = $_SESSION['count']++;
        }else{ 
            // If not set, we can start counting
            return $_SESSION['count'] = 1;
        }
    }





    // A GETTER FUNCTION - TO GET A PRIVATE VALUE($signed_in) FROM OUR CLASS
    // We can call this function anywhere to check if the user is logged in or not
    public function is_signed_in(){
        return $this->signed_in;
    }

    // LOGIN THE USER
    public function login($user){
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }
    // ...
    // TO CHECK THE USER IN DATABASE

    // LOG OUT THE USER
    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    // TO CHECK IF THE $_SESSION['user_id'] IS SET, THEN SET VALUES DEPENDS ON THE RESULT
    private function check_the_login(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;  // Later on we will use this value to find out if the user is loged in or not
        }else{
            unset($this->user_id);
            $this->signed_in = false;
        }
    }
}

$session = new Session();
$message = $session->message();


?>
