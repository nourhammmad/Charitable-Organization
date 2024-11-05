<?php
class DonationType{
    public $type;
    public $quantity;

    public function __construct($type, $quantity) {
        $this->type = $type;
        $this->quantity = $quantity;
    }
}
?>