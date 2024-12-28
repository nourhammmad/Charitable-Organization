<?php
class ModalContentFactory {
    public static function create($type) {
        switch ($type) {
            case 'organization':
                return self::getOrganizationModal();
            case 'donors':
                return self::getDonorsModal();
            case 'createEvent':
                return self::getCreateEventModal();
            case 'createTask':
                return self::getCreateTaskModal();
            case 'books':
                return self::getBooksModal();
            case 'clothes':
                return self::getClothesModal();
            case 'money':
                return self::getMoneyModal();
            case 'sendAll':
                return self::getSendNotificationModal();
            default:
                return ['error' => 'Unknown modal type'];
        }
    }

    private static function getOrganizationModal() {
        return [
            'title' => 'Retrieve Organization',
            'fields' => [
                ['type' => 'text', 'name' => 'organizationId', 'placeholder' => 'Organization ID'],
            ]
        ];
    }

    private static function getDonorsModal() {
        return [
            'title' => 'Retrieve Donors',
            'fields' => [
                ['type' => 'text', 'name' => 'donorId', 'placeholder' => 'Donor ID'],
            ]
        ];
    }

    private static function getCreateEventModal() {
        return [
            'title' => 'Create Event',
            'fields' => [
                ['type' => 'text', 'name' => 'eventName', 'placeholder' => 'Event Name'],
                ['type' => 'date', 'name' => 'eventDate', 'placeholder' => 'Event Date'],
                ['type' => 'number', 'name' => 'capacity', 'placeholder' => 'Capacity'],
            ]
        ];
    }

    private static function getCreateTaskModal() {
        return [
            'title' => 'Create Task',
            'fields' => [
                ['type' => 'text', 'name' => 'taskName', 'placeholder' => 'Task Name'],
                ['type' => 'text', 'name' => 'description', 'placeholder' => 'Task Description'],
            ]
        ];
    }

    private static function getBooksModal() {
        return [
            'title' => 'Track Books',
            'fields' => [
                ['type' => 'text', 'name' => 'bookId', 'placeholder' => 'Book ID'],
            ]
        ];
    }

    private static function getClothesModal() {
        return [
            'title' => 'Track Clothes',
            'fields' => [
                ['type' => 'text', 'name' => 'clothesId', 'placeholder' => 'Clothes ID'],
            ]
        ];
    }

    private static function getMoneyModal() {
        return [
            'title' => 'Track Money Donations',
            'fields' => [
                ['type' => 'number', 'name' => 'donationAmount', 'placeholder' => 'Amount'],
            ]
        ];
    }

    private static function getSendNotificationModal() {
        return [
            'title' => 'Send Notification',
            'fields' => [
                ['type' => 'email', 'name' => 'mail', 'placeholder' => 'Recipient Email'],
                ['type' => 'text', 'name' => 'subject', 'placeholder' => 'Subject'],
                ['type' => 'textarea', 'name' => 'body', 'placeholder' => 'Message Body'],
            ]
        ];
    }
}
