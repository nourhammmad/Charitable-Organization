<?php 
class ViewNotificationsCommand implements ICommand {
    private $donorId;

    public function __construct($donorId) {
        $this->donorId = $donorId;
    }

    public function execute() {
        try {
            // Fetch notifications for the donor
            $notifications = RegisterUserTypeModel::getNotifications($this->donorId);
            
            // Check if notifications exist
            if ($notifications) {
                echo json_encode([
                    'success' => true,
                    'notifications' => $notifications
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No notifications found.'
                ]);
            }
        } catch (Exception $e) {
            // Handle any exceptions
            echo json_encode([
                'success' => false,
                'message' => 'An error occurred while fetching notifications.',
                'error' => $e->getMessage()
            ]);
        }
    }
}
