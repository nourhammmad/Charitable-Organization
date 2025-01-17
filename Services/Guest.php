<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/User.php";




class Guest extends user{


    public function __construct() {
        parent::__construct('Guest');
    }

    public function getUserType() {
    return $this->type;
    }
   
    public function login() {
        $_SESSION['user_id'] = $this->userid;
        $_SESSION['user_type'] = $this->type;
        header("Location: ./views/HomeView.php");
        exit();
    }
    
    
}

?>