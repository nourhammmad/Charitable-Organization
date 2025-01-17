<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/TravelManagement.php";

class AddTravelPlanCommand implements ActionCommand {
    public function execute() {
        $travel = new TravelManagement();
        $type = $_POST['type'] ?? null;
        $dest = $_POST['destination'] ?? null;
        $attr = $_POST['attributes'] ?? null;

        if ($type && $dest && $attr) {
            $travel->createTravelPlan($type, $dest, $attr);
            echo json_encode(["success" => true, "message" => "Travel plan added."]);
        } else {
            echo json_encode(["success" => false, "message" => "Missing fields."]);
        }
    }
}
?>
