<?php
require_once "../Services/Donation.php";



class Donor {
    private DonationType $Dt;

    public function setDonationStrategy(DonationType $donationStrategy) {
        $this->Dt = $donationStrategy;
    }

    public function donate($donorId, $quantity) {
        if ($this->Dt) {
            $this->Dt->donate($donorId, $quantity);
        } else {
            throw new Exception("Donation strategy not set.");
        }
    }
}
?>
