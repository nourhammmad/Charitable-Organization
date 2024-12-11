<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Services/IDonationState.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/Services/CreateState.php"; 
require_once $_SERVER['DOCUMENT_ROOT'] . "/Services/DeleteState.php"; 
require_once $_SERVER['DOCUMENT_ROOT'] . "/Services/RedoOnlyState.php"; 

 
class DonationLog {
    private $log_id;
    private $donorId;
    private $organization_id;
    private $donation_item_id;
    private $donation_type_id;
    private $previous_state;
    private $current_state;
    private $donationId;
    private IDonationState $state;
 
    public function __construct($log_id, $donorId, $organization_id, $donation_item_id, $donation_type_id, $previous_state, $current_state,$donationId) {
        $this->log_id = $log_id;
        $this->donorId = $donorId;
        $this->organization_id = $organization_id;
        $this->donation_item_id = $donation_item_id;
        $this->donation_type_id = $donation_type_id;
        $this->previous_state = $previous_state;
        $this->current_state = $current_state;
        $this->donationId=$donationId;
        $this->initializeState();
    }
 
    public function toArray() {
        return [
            'log_id' => $this->log_id,
            'donor_id' => $this->donorId,
            'organization_id' => $this->organization_id,
            'donation_item_id' => $this->donation_item_id,
            'donation_type_id' => $this->donation_type_id,
            'previous_state' => $this->previous_state,
            'current_state' => $this->current_state,
            'donationId'=> $this->donationId,
        ];
    }
    public function getLogId() {
        return $this->log_id;
    }
    public function getLogdonationId() {
        return $this->donationId;
    }
    public function getLogCurrentState() {
        return $this->current_state;
    }
    public function getLogtypeId() {
        return $this->donation_type_id;
    }
    public function getLogitemId() {
        return $this->donation_item_id;
    }


 
    public function setDonationState(IDonationState $state) {
        $this->state = $state;
    }
 
    public function getDonationState() {
        return $this->state;
    }
 

    private function initializeState() {
        if($this->donation_type_id==1){
            $this->setDonationState(new RedoOnlyState());
        }
        else{
            if ($this->current_state === "CREATE") {
            $this->setDonationState(new CreateState());
            }
            else if ($this->current_state === "DELETE"){
                $this->setDonationState(new DeleteState());
            }
        }


    }
}
?>