<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/controllers/DonationManagement.php";

class TrackMoneyCommand implements ActionCommand {
    public function execute() {
        DonationManagement::handelTrack(1);
        echo json_encode(["success" => true, "message" => "Money tracked successfully."]);
    }
}
?>
