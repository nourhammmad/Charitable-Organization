<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/Resources.php";

class CreateResourceCommand implements ActionCommand {
    public function execute() {
        $name = $_POST['resourceName'] ?? null;
        if ($name && resource::createResource($name)) {
            echo json_encode(["success" => true, "message" => "Resource created successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Resource name is required or creation failed."]);
        }
    }
}
?>
