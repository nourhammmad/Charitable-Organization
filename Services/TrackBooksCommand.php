<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/controllers/DonationManagement.php";

class TrackBooksCommand implements ActionCommand {
    public function execute() {
        DonationManagement::handelTrack(2);
        echo json_encode(["success" => true, "message" => "Books tracked successfully."]);
    }
}
?>
