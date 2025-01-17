<?php

$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\Database.php";
require_once $server.'\Services/IObserver.php';
require_once $server.'\db-populate.php';

class Volunteer {
    private $id;
    // //private $registeredUserId;
    // //private $organizationId;
    // //private $specificField;
    // private $skills;

    public function __construct($id) {
        $this->id = $id;
  
    }

    // Getter methods
    public function getId() { return $this->id; }   
}
?>
