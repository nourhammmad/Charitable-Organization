<?php
class Notification {
    public $id;
    public $recipientId;
    public $message;
    public $createdAt;
    public $senderId;
    public $senderName;

    public function __construct($id, $recipientId, $message, $createdAt, $senderId, $senderName) {
        $this->id = $id;
        $this->recipientId = $recipientId;
        $this->message = $message;
        $this->createdAt = $createdAt;
        $this->senderId = $senderId;
        $this->senderName = $senderName;
    }
}

