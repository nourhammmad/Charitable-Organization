<?php

require_once "./Services/User.php";
require_once "../Charitable-Organization/models/RegisteredUserModel.php";
require_once "../Charitable-Organization/models/DonorModel.php";
require_once "./models/VolunteerModel.php";



class RegisterUser extends user {
    private $id;
    private $email;
    private $userName;
    private $passwordHash;
    //private $createdAt;
    private $category;
    

    public function __construct($userid,$registeredUserId,$email, $userName, $passwordHash,$category ) {
        parent::__construct($userid,'RegisteredUserType');
        $this->id =$registeredUserId;
        $this->email = $email;
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
        $this->category=$category;
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
            }
        }
        exit();
    }

    public function signUp(){
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_category'] = $this->category;
        if($this->category === 'Donor'){
        if(DonarModel::createDonor($this->id,1)){
           $donorId = DonarModel::getLastInsertDonorId();
           header("Location: ./views/HomeView.php?donor_id=$donorId");
        exit();
        }}
        elseif ($this->category === 'Volunteer') {
            if (VolunteerModel::createVolunteer($this->id,1)) { // Assuming createVolunteer is a method to initialize volunteer data
                echo "dakhalt";
                $volunteerId = VolunteerModel::getLastInsertVolunteerId(); // Get the last inserted Volunteer ID
                //header("Location: ./views/VolunteerDashboard.php?volunteer_id=$volunteerId"); // Redirect to volunteer dashboard
                //exit();
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
