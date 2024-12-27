<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/Services/DonationLogIterableInterface.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/DonationLog.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/DonationLogIterator.php";

class DonationLogIterable implements DonationLogIterableInterface {
    private $logs = [];

    public function __construct(array $logs) {
        $this->logs = $logs;
    }

    public function getIterator(): Iterator {
        return new DonationLogIterator($this->logs);
    }
}
