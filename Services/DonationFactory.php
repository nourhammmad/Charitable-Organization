
<?php


// require_once  $_SERVER['DOCUMENT_ROOT']."\models\configFactory.php";

abstract class DonationFactory{
   abstract static function createDonation($donationType, $donorId, $type, $size, $color, $quantity, $title, $author, $year, $amount, $currency, $cardNumber);

}