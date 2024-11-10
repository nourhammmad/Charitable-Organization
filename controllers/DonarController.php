<?php
class Donor {
    private $donationStrategy;

    public function setDonationStrategy(DonationStrategy $donationStrategy) {
        $this->donationStrategy = $donationStrategy;
    }

    public function donate($donorId, $quantity) {
        if ($this->donationStrategy) {
            $this->donationStrategy->donate($donorId, $quantity);
        } else {
            throw new Exception("Donation strategy not set.");
        }
    }
}
?>
