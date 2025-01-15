<?php

require_once $_SERVER['DOCUMENT_ROOT']."\Database.php";

class VolunteerTaskAssignmentModel {

    // Assign a task to a user
    public static function assignTaskToUser($taskId, $userId): bool {
        // Ensure taskId and userId are properly escaped to avoid SQL injection
    
 

        $query = "INSERT INTO VolunteerTaskAssignments (volunteerId, taskId) VALUES ($userId, $taskId)";
        
         return Database::run_query($query);
    }
    
   public static function fetchAllTasks() {
    $connection = Database::get_connection();
    $query = "SELECT * FROM Tasks";  

    $result = $connection->query($query);

    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);  
    } else {
        return [];
}
}
public static function isVolunteerAssignedToTask($volunteerId, $taskId) {
    // Query to check if volunteer is already assigned to the task
    $query = "SELECT * FROM VolunteerTaskAssignments WHERE volunteerId = $volunteerId AND taskId = $taskId";
    
    // Run the query
    $result = Database::run_select_query($query);

    // Check if the result contains any rows
    if ($result && $result->num_rows > 0) {
        return true; // Volunteer is already assigned to the task
    }
    
    return false; // Volunteer is not assigned to the task
}
}