<?php
class Publisher implements ISubject{
    private $observers = [];
    private $eventId;

    public function __construct($observers, $eventId) {
        $this->eventId = $eventId;

        // Initialize with unique observers
        $this->addObserver($observers);
    }

    public function addObserver($observers) {
        if (is_array($observers)) {
            foreach (array_unique($observers) as $volunteerId) {
                if (!empty($volunteerId) && is_numeric($volunteerId)) { // Validate ID
                    $this->observers[] = intval($volunteerId); // Add only valid IDs
                }
            }
        } elseif (!empty($observers) && is_numeric($observers)) {
            if (!in_array($observers, $this->observers)) { // Check for duplicates
                $this->observers[] = intval($observers); // Single valid observer
            }
        }
    }

    public function notifyObservers($message) {
        foreach ($this->observers as $observer) {
            EventModel::saveNotificationToDatabase($observer, $message, $this->eventId);
        }
    }

    public function listObservers() {
        foreach ($this->observers as $observer) {
            echo "Observer ID: $observer\n";
        }
    }
}

