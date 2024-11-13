<?php

require_once "./Services/User.php";
require_once "../Charitable-Organization/models/RegisteredUserModel.php";
require_once "../Charitable-Organization/models/DonorModel.php";
require_once "./models/VolunteerModel.php";



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
        if($this->category=='Donor'){
            $res=DonarModel::getDonorByRegisteredId($_SESSION['user_id']);
            if($res){
                $donorId = $res->getId();
                header("Location: ./views/HomeView.php?donor_id=$donorId");
             exit();
            }
        }
        
        exit();
    }

    public function signUp(){
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_type'] = $this->type;
        if(DonarModel::createDonor($this->id,1)){
           $donorId = DonarModel::getLastInsertDonorId();
           header("Location: ./views/HomeView.php?donor_id=$donorId");
        exit();
        }
        elseif ($this->type === 'Volunteer') {
            if (VolunteerModel::createVolunteer($this->id)) { // Assuming createVolunteer is a method to initialize volunteer data
                $volunteerId = VolunteerModel::getLastInsertVolunteerId(); // Get the last inserted Volunteer ID
                header("Location: ./views/VolunteerDashboard.php?volunteer_id=$volunteerId"); // Redirect to volunteer dashboard
                exit();
            }
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
