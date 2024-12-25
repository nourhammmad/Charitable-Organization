<?php


require_once $_SERVER['DOCUMENT_ROOT']."./Services/User.php";
require_once $_SERVER['DOCUMENT_ROOT']."./models/RegisteredUserModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."./models/DonorModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."./models/VolunteerModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."./models/VolunteerModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."./models/TaskModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."./controllers/VolunteerCotroller.php";



class RegisterUser extends user {
    private $id;
    private $email;
    private $userName;
    private $passwordHash;
    private $phone;
    private $category;
    

    public function __construct($userid,$registeredUserId,$email, $userName, $passwordHash,$phone,$category ) {
        parent::__construct($userid,'RegisteredUserType');
        $this->id =$registeredUserId;
        $this->email = $email;
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
        $this->phone = $phone;
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
        echo("kjdhfjdg");
        echo($this->category);
        if($this->category === 'Donor'){
            echo ("2ay araf");
        if(DonarModel::createDonor($this->id,1)){
            echo("AAAAAAAAAAAAAAAAAAA");
            $donorId = DonarModel::getLastInsertDonorId();
            echo("jdhadiyfgidasgf");
           header("Location: ./views/HomeView.php?donor_id=$donorId ");
        exit();
        }}
        elseif ($this->category === 'Volunteer') {
            if (VolunteerModel::createVolunteer($this->id,1)) { // Assuming createVolunteer is a method to initialize volunteer data
                echo "dakhalt";
                $volunteerId = VolunteerModel::getLastInsertVolunteerId(); // Get the last inserted Volunteer ID
                $taskId=TaskModel::getLastInsertTasksId();
                $handler = new VolunteerCotroller($volunteerId);
                $events = $handler->displayAvailableEvents();
                $tasks = $handler->displayAllTasks();
                // Store events and tasks in session (for use in the dashboard)
                $_SESSION['volunteer_events'] = $events;
                $_SESSION['volunteer_tasks'] = $tasks;
                header("Location: ./views/VolunteerDashboard.php?volunteer_id=$volunteerId&task_id=$taskId"); // Redirect to volunteer dashboard
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
