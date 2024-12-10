<?php
require_once $_SERVER['DOCUMENT_ROOT']."\Services\Donation.php";



class Donor {
    private $id;
    private DonationType $Dt;
    private $donationState;

    public function __construct($id)
    {
        $this->id =$id;   
    }
    public function setDonationState(IDonationState $state) {
        $this->donationState = $state;
    }

    public function getDonationState() {
        return $this->donationState;
    }
    public function setDonationStrategy(DonationType $donationStrategy) {
        $this->Dt = $donationStrategy;
    }
    public function getId(){
        return $this->id;
    }

    public function donate($donarID) {
        if ($this->Dt) {
            if($this->Dt->donate($this->id)) {
                $des=(String)DonationModel::getDonationDescription();
                DonarModel::addDescription($des,$donarID);
                return true;
            }
            else return false;
        } else {
            throw new Exception("Donation strategy not set.");
            return false;
        }
    }
}
?>
