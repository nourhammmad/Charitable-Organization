<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/UndoDonationCommandAction.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/DonorModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/donarLogFile.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";

class UndoDonationCommand implements ActionCommand {
    private $donorId;
    private $logId;

    public function __construct($donorId, $logId) {
        $this->donorId = $donorId;
        $this->logId = $logId;
    }

    public function execute() {
        // Undo logic
        $donor = DonarModel::getDonorById($this->donorId);
        $donationLog = donarLogFile::getLogById($this->logId);

        // Check if donor and donation log exist and if it's allowed to undo
        if ($donor && $donationLog) {
            if ($donationLog->getDonationState()->canUndo()) {
                $donor->setDonationCommand(new UndoDonationCommandAction($donationLog));
                $donor->executeCommand();
                echo json_encode(['success' => true, 'message' => 'Undo successful.']);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Undo not allowed in current state.']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Donor not found!']);
        }

        exit; // Ensure no additional output after this response
    }
}
?>
