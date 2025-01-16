<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/RedoDonationCommandAction.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/DonorModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/donarLogFile.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";

class RedoDonationCommand implements ActionCommand {
    private $donorId;
    private $logId;

    public function __construct($donorId, $logId) {
        $this->donorId = $donorId;
        $this->logId = $logId;
    }

    public function execute() {
        // Redo logic
        $donor = DonarModel::getDonorById($this->donorId);
        $donationLog = donarLogFile::getLogById($this->logId);

        if ($donor && $donationLog && $donationLog->getDonationState()->canRedo()) {
            $donor->setDonationCommand(new RedoDonationCommandAction($donationLog, $this->donorId));
            $donor->executeCommand();
            echo json_encode(['success' => true, 'message' => 'Redo successful.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Redo not allowed or donor not found.']);
        }
        exit; // Ensure no additional output after this response
    }
}
?>
