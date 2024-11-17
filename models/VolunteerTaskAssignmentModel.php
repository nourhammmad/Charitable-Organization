<?php

require_once "../Database.php";

class VolunteerTaskAssignmentModel {

    // Assign a task to a user
    public static function assignTaskToUser($taskId, $userId): bool {
        $query = "INSERT INTO TaskAssignments (`taskId`, `userId`) VALUES ('$taskId', '$userId')";
        return Database::run_query(query: $query);
    }
    public static function getAllTasks(): array {
        $query = "SELECT * FROM Tasks";
        $res = Database::run_select_query(query: $query);
        
        // Convert the result to an array of associative arrays or return an empty array if no tasks are found
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Unassign a task from a user
    // public static function unassignTaskFromUser($taskId, $userId): bool {
    //     $query = "DELETE FROM TaskAssignments WHERE `taskId` = '$taskId' AND `userId` = '$userId'";
    //     return Database::run_query(query: $query);
    // }

    // // Retrieve tasks assigned to a specific user
    // public static function getTasksForUser($userId): array {
    //     $query = "SELECT t.* 
    //               FROM Tasks t
    //               INNER JOIN TaskAssignments ta ON t.id = ta.taskId
    //               WHERE ta.userId = '$userId'";
    //     $res = Database::run_select_query(query: $query);

    //     return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    // }

    // // Retrieve users assigned to a specific task
    // public static function getUsersForTask($taskId): array {
    //     $query = "SELECT u.* 
    //               FROM Users u
    //               INNER JOIN TaskAssignments ta ON u.id = ta.userId
    //               WHERE ta.taskId = '$taskId'";
    //     $res = Database::run_select_query(query: $query);

    //     return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    // }

    // // Assign multiple users to a task
    // public static function assignMultipleUsersToTask($taskId, array $userIds): bool {
    //     foreach ($userIds as $userId) {
    //         $query = "INSERT INTO TaskAssignments (`taskId`, `userId`) VALUES ('$taskId', '$userId')";
    //         if (!Database::run_query(query: $query)) {
    //             return false;
    //         }
    //     }
    //     return true;
    // }

    // // Remove all assignments for a task
    // public static function unassignAllUsersFromTask($taskId): bool {
    //     $query = "DELETE FROM TaskAssignments WHERE `taskId` = '$taskId'";
    //     return Database::run_query(query: $query);
    // }
}
