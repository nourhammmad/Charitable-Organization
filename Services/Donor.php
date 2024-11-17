<?php
$server=$_SERVER['DOCUMENT_ROOT'];

require_once $server."./Services/Donation.php";



class Donor {
    private $id;
    private DonationType $Dt;

    public function __construct($id)
    {
        $this->id =$id;   
    }

    public function setDonationStrategy(DonationType $donationStrategy) {
        $this->Dt = $donationStrategy;
    }
    public function getId(){
        return $this->id;
    }

    public function donate($donarID) {
        if ($this->Dt) {
            if($this->Dt->donate()) {
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
