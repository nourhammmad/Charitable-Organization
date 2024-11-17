<?php
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Services/Donation.php";
require_once "F:/senior 2/Design Patterns/project/Charitable-Organization/Services/RegisterUser.php";



class Donor extends RegisterUser {
    private $id;
    //should be user so dont do it now 
    private $reguserId;
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

    public function donate() {
        if ($this->Dt) {
            if($this->Dt->donate($this->id)) {
                $des=(String)DonationModel::getDonationDescription();
                DonarModel::addDescription($des,$this->id);
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
