<?php

require_once "./models/VolunteerTaskAssignmentModel.php";
require_once "../models/TaskModel.php";

class VolunteerTaskAssignmentController {

    // Assign a task to a user
    public static function assignTaskToUser($taskId, $userId): string {
        if (VolunteerTaskAssignmentModel::assignTaskToUser($taskId, $userId)) {
            return "Task $taskId assigned to user $userId successfully.";
        }
        
        return "Failed to assign task $taskId to user $userId.";
    }

    public function getAvailableEvents() {
        // Fetch all events using the model
        $events = VolunteerTaskAssignmentModel::getAllTasks();
        
        if (!empty($events)) {
            return $events;
        } else {
            return "No available events at the moment.";
        }
    }
    public function viewAllTasks() {
        $tasks = TaskAssignmentController::getAllTasks();
        
        if (is_array($tasks) && !empty($tasks)) {
            echo "Available Tasks:<br>";
            foreach ($tasks as $task) {
                echo "Task ID: " . $task['id'] . ", Name: " . $task['name'] . ", Required Skill: " . $task['requiredSkill'] . "<br>";
            }
        } else {
            echo "No tasks available at the moment.";
        }
    }
    
    // Unassign a task from a user
    // public static function unassignTaskFromUser($taskId, $userId): string {
    //     if (TaskAssignmentModel::unassignTaskFromUser($taskId, $userId)) {
    //         return "Task $taskId unassigned from user $userId successfully.";
    //     }
    //     return "Failed to unassign task $taskId from user $userId.";
    // }

    // // Get tasks assigned to a specific user
    // public static function getTasksForUser($userId): array {
    //     return TaskAssignmentModel::getTasksForUser($userId);
    // }

    // // Get users assigned to a specific task
    // public static function getUsersForTask($taskId): array {
    //     return TaskAssignmentModel::getUsersForTask($taskId);
    // }

    // // Assign multiple users to a task
    // public static function assignMultipleUsersToTask($taskId, array $userIds): string {
    //     if (TaskAssignmentModel::assignMultipleUsersToTask($taskId, $userIds)) {
    //         return "Task $taskId assigned to multiple users successfully.";
    //     }
    //     return "Failed to assign task $taskId to multiple users.";
    // }

    // // Remove all assignments for a task
    // public static function unassignAllUsersFromTask($taskId): string {
    //     if (TaskAssignmentModel::unassignAllUsersFromTask($taskId)) {
    //         return "All users unassigned from task $taskId successfully.";
    //     }
    //     return "Failed to unassign all users from task $taskId.";
    // }

    // // Get task by ID
    // public static function getTaskById($taskId) {
    //     return TaskModel::getTaskById($taskId);
    // }

    // // Get all tasks
    // public static function getAllTasks(): array {
    //     return TaskModel::getAllTasks();
    // }
}
