<?php
require_once $_SERVER['DOCUMENT_ROOT']."\Services\DonationLog.php";
require_once $_SERVER['DOCUMENT_ROOT']."\models\donarLogFile.php";

class UndoDonationCommand implements ICommand {
    private $donorLog;
    
    public function __construct($donorLog) {
        $this->donorLog = $donorLog;
    }

    public function execute() {
        $this->undo();
    }

    public function undo() {
        
        donarLogFile::undoDonation($this->donorLog->getLogId());
        
        $this->donorLog->setDonationState(new DeleteState());


    }

}
