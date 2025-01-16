<?php
class RedoDonationCommandAction implements ICommand {
    private $donationlog;
    private $donorID;

    public function __construct($donationlog,$donorId) {
        $this->donationlog = $donationlog;
        $this->donorID =$donorId;
    }

    public function execute() {
        $this->redo();
    }

    public function redo() {
        donarLogFile::redoDonation($this->donationlog->getLogId(),$this->donorID);
        $this->donationlog->setDonationState(new CreateState());
    }
}