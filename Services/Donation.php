<?php

abstract class DonationType {
    protected $quantityDonated;
    protected $donationId;

    abstract public function donate($donorid): bool;

    public function __construct($donationId, $quantityDonated) {
        $this->donationId = $donationId;
        $this->quantityDonated = $quantityDonated;
    }
    protected function getQuantity(){
        return $this->quantityDonated;
    }

    public function getDonationInfo() {
        return "Donation ID: " . $this->donationId . ", Quantity: " . $this->quantityDonated;
    }
}

?>