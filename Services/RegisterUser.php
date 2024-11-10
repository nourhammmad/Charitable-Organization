<?php

require_once "./Services/User.php";
require_once "../Charitable-Organization/models/RegisteredUserModel.php";


class RegisterUser extends user {
    private $email;
    private $userName;
    private $category;


    public function __construct($email, $userName, $category) {
        parent::__construct('RegisteredUserType');
        $this->email=$email;
        $this->category=$category;
        $this->userName=$userName;
    }

    public function login() {
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_type'] = $this->type;
        //$regUser=RegisterUserTypeModel::findById($this->id);

        exit();
    }

    public function signUp(){
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_type'] = $this->type;
        if(RegisterUserTypeModel::createDonor($this->id,1)){
           $donorId = RegisterUserTypeModel::getLastInsertDonorId();
           header("Location: ./views/HomeView.php?donor_id=$donorId");
        exit();
        }
    }

    public function getId() {
        return $this->id; 
    }

    public function getCategory(){
        return $this->category;
    }

    public function getUserType() {
        return $this->type;
    }

}
