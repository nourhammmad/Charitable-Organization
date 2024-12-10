<?php 
require_once $_SERVER['DOCUMENT_ROOT'] ."./Services/IDonationState.php";

class DonationLog {
    private $logId;
    private $donorId;
    private $organizationId;
    private $donationItemId;
    private $donationTypeId;
    private $previousState;
    private $currentState;

    public function __construct($logId, $donorId, $organizationId, $donationItemId, $donationTypeId, $previousState, $currentState) {
        $this->logId = $logId;
        $this->donorId = $donorId;
        $this->organizationId = $organizationId;
        $this->donationItemId = $donationItemId;
        $this->donationTypeId = $donationTypeId;
        $this->previousState = $previousState;
        $this->currentState = $currentState;
    }
    public function setDonationState(IDonationState $state) {
        $this->currentState = $state;
    }
    public function getDonationState() {
        return $this->currentState;
    }
}