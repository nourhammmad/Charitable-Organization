<?php

require_once $_SERVER['DOCUMENT_ROOT']."./Database.php";

class VolunteerTaskAssignmentModel {

    // Assign a task to a user
    public static function assignTaskToUser($taskId, $userId): bool {
        $query = "INSERT INTO TaskAssignments (taskId, userId) VALUES ('$taskId', '$userId')";
        return Database::run_query(query: $query);
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
}