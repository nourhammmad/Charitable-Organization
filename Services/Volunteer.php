<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\Database.php";
require_once $server.'\Services/IObserver.php';
class Volunteer implements IObserver{
    private $id;
    // //private $registeredUserId;
    // //private $organizationId;
    // //private $specificField;
    // private $skills;

    public function __construct($id) {
        $this->id = $id;
        // $this->registeredUserId = $registeredUserId;
        // $this->organizationId = $organizationId;
        // $this->specificField = $specificField;
        // $this->skills = $skills;
    }

    // Getter methods
    public function getId() { return $this->id; }
    // public function getRegisteredUserId() { return $this->registeredUserId; }
    // public function getOrganizationId() { return $this->organizationId; }
    // public function getSpecificField() { return $this->specificField; }
    //public function getSkills() { return $this->skills; }

    // // Setter for specific field
    // //public function setSpecificField($specificField) { $this->specificField = $specificField; }

    // // Set skills
    // public function setSkills($skills) { $this->skills = $skills; }
        // Implement the notify method from IObserver
        public function notify($message) {

            // For testing purposes, let's just echo the message
            echo "Notification for Volunteer $message\n";
        }
}
?>
