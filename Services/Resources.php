<?php

require_once $_SERVER['DOCUMENT_ROOT']."\models\ResourceModel.php";
class resource{
    private $id;
    private $name;

    public function __construct($id , $name ) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }


    public static function createResource($name) {
        return ResourceModel::createResource($name);
    }

    // public static function transferResource($resourceId, $destination) {
    //     return ResourceModel::transferResource($resourceId, $destination);
    // }

    public static function getAllResources() {
        return ResourceModel::getAllResources();
    }



}