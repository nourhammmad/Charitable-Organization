<?php
class Notification {
    public $id;
    public $recipientId;
    public $message;
    public $timestamp;

    public function __construct($id, $recipientId, $message, $timestamp) {
        $this->id = $id;
        $this->recipientId = $recipientId;
        $this->message = $message;
        $this->timestamp = $timestamp;
    }

    // Optionally, you could add methods to format the data or other functionality
}
