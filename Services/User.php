<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."/models/UserModel.php";

abstract class User {
    protected $userid;
    protected $type;

    // Constructor to set the type
    public function __construct($userId,$type) {
        $this->userid=$userId;
        $this->type = $type;
    }

    abstract public function getUserType();

    // Getter for id
    public function getId() {
        return $this->userid;
    }

    // Setter for id (if needed)
    public function setId($id) {
        $this->userid = $id;
    }

    // Getter for type
    public function getType() {
        return $this->type;
    }

    abstract public function login();
}

