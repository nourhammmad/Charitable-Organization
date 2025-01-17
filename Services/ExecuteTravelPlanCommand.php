<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/TravelManagement.php";

class ExecuteTravelPlanCommand implements ActionCommand {
    public function execute() {
        $planId = intval($_POST['planId'] ?? 0);
        if ($planId > 0) {
            $travelManagement = new TravelManagement();
            $travelManagement->executeTravelPlan($planId);
            echo json_encode(["success" => true, "message" => "Plan executed."]);
        } else {
            echo json_encode(["success" => false, "message" => "Plan ID required."]);
        }
    }
}
?>
