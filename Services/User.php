<?php

require_once "./models/UserModel.php";

abstract class  user{
    protected $id;
    protected $type;

    public function __construct($id, $type) {
        $this->id = $id;
        $this->type = $type;
    }
    public function getId (){}
}

