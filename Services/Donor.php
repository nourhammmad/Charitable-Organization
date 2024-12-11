<?php
require_once $_SERVER['DOCUMENT_ROOT']."\Services\Donation.php";
require_once $_SERVER['DOCUMENT_ROOT']."\Services\ICommand.php";



class Donor {
    private $id;
    private DonationType $Dt;
    private ICommand $donationCommand;

    public function __construct($id)
    {
        $this->id =$id;   
    }
    public function setDonationCommand(ICommand $donationCommand) {
        $this->donationCommand = $donationCommand;
    }
    public function executeCommand(){
        $this->donationCommand->execute();
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
