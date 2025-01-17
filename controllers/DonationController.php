<?php

require_once  $_SERVER['DOCUMENT_ROOT']."\Services\CommandHandler.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $donorId = $_POST['donorId'] ?? null;
    $userId=$_POST['userId'] ?? null;
    $logId = $_POST['log_id'] ?? null;
    $donationType = $_POST['donationType'] ?? null;  // Donation type for 'add_donation'
    $donationData = null;

    // Collect donation data if donationType is provided
    if ($donationType) {

        $action='add_donation';
        $donationData = [
            'quantity' => $_POST['quantity'] ?? null,
            'bookTitle' => $_POST['bookTitle'] ?? null,
            'author' => $_POST['author'] ?? null,
            'publicationYear' => $_POST['publicationYear'] ?? null,
            'type' => $_POST['type'] ?? null,
            'size' => $_POST['size'] ?? null,
            'color' => $_POST['color'] ?? null,
            'amount' => $_POST['amount'] ?? null,
            'currency' => $_POST['currency'] ?? null,
            'paymentType' => $_POST['paymentType'] ?? null,
            'cardNumber' => $_POST['cardNumber'] ?? null
        ];
    }

    // Ensure action and donorId are provided
    if ($action && ($donorId||$userId)) {
        CommandHandler::handleRequest($action, $donorId, $logId, $donationType, $donationData,$userId);
    } else {
        echo json_encode(['success' => false, 'message' => 'Action or donorId is missing.']);
    }
}
