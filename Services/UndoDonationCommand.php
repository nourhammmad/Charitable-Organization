<?php
require_once $_SERVER['DOCUMENT_ROOT']."\Services\DonationLog.php";
require_once $_SERVER['DOCUMENT_ROOT']."\models\donarLogFile.php";

class UndoDonationCommand implements ICommand {
    private $donarLog;
    
    public function __construct($donarLog) {
        $this->donarLog = $donarLog;
    }

    public function execute() {
        $this->undo();
    }

    public function undo() {
        
        donarLogFile::undoDonation($this->donarLog->getLogId());
        
        $this->donarLog->setDonationState(new DeleteState());


    }

}
