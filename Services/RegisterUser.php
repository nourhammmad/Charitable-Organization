<?php

require_once "./Services/User.php";

class RegisterUser extends User {

    public function __construct($id) {
        parent::__construct($id, 'RegisteredUserType');
    }

    public function login() {
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_type'] = $this->type;
        exit();
    }

    public function signUp(){
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_type'] = $this->type;
        exit();
    }

    // Getter method for id
// Example if getId() is returning an array like ['id' => 'some-id']
public function getId() {
    return $this->id['id'];  // Ensure it returns a string or number
}

}
