<?php

require_once "./Services/User.php";



class RegisterUser extends user{

    public function __construct($id) {
        parent::__construct($id, 'RegisteredUserType');
    }

    public function login() {
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_type'] = $this->type;
        //header("Location: dashboard.php");//REDIRECT
        exit();
    }

    public function signUp(){
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_type'] = $this->type;
        //header("Location: dashboard.php");//REDIRECT
        exit();

    }




}


