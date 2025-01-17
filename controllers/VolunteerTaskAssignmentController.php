<?php
$server = $_SERVER['DOCUMENT_ROOT'];
require_once $server."/models/VolunteerTaskAssignmentModel.php";
require_once $server."/models/TaskModel.php";

class VolunteerTaskAssignmentController {

    // Assign a task to a user
    public static function assignTaskToUser($taskId, $userId): string {
        if (VolunteerTaskAssignmentModel::assignTaskToUser($taskId, $userId)) {
            return "Task $taskId assigned to user $userId successfully.";
        }
        
        return "Failed to assign task $taskId to user $userId.";
    }

    public function viewAllTasks() {
        $tasks = VolunteerTaskAssignmentModel::fetchAllTasks();
        
        if (is_array($tasks) && !empty($tasks)) {
            return $tasks;
        } else {
            return [];  // Return an empty array if no events
        }
    }
    
}