<?php

require_once "./models/UserModel.php";

abstract class User {
    protected $id;
    protected $type;

    // Constructor to set the type
    public function __construct($type) {
        $this->type = $type;
    }

    abstract public function getUserType();

    // Getter for id
    public function getId() {
        return $this->id;
    }

    // Setter for id (if needed)
    public function setId($id) {
        $this->id = $id;
    }

    // Getter for type
    public function getType() {
        return $this->type;
    }

    abstract public function login();
}

