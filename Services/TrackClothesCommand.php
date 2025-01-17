<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/controllers/DonationManagement.php";

class TrackClothesCommand implements ActionCommand {
    public function execute() {
        DonationManagement::handelTrack(3);
        echo json_encode(["success" => true, "message" => "Clothes tracked successfully."]);
    }
}
?>
