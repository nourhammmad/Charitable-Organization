<?php
require_once $_SERVER['DOCUMENT_ROOT']."./Database.php";

class TaskModel {

    // Create a new task
    public static function createTask($id, $name, $description, $requiredSkill, $timeSlot, $location): bool {
        $query = "INSERT INTO Tasks (`id`, `name`, `description`, `requiredSkill`, `timeSlot`, `location`) 
                  VALUES ('$id', '$name', '$description', '$requiredSkill', '$timeSlot', '$location')";
        return Database::run_query(query: $query);
    }

    // Retrieve a task by ID
    public static function getTaskById($id) {
        $query = "SELECT * FROM Tasks WHERE id = '$id'";
        $res = Database::run_select_query(query: $query);
        
        // Return a single associative array or null if no task is found
        return $res ? $res->fetch_assoc() : null;
    }

    // Update task information
    public static function updateTask($id, $name, $description, $requiredSkill, $timeSlot, $location): bool {
        $query = "UPDATE Tasks 
                  SET name = '$name', description = '$description', requiredSkill = '$requiredSkill', 
                      timeSlot = '$timeSlot', location = '$location' 
                  WHERE id = '$id'";
        return Database::run_query(query: $query);
    }
    public static function getLastInsertTasksId() {
        $query = "SELECT `id` FROM Tasks ORDER BY `id` DESC LIMIT 1;";
        $res = Database::run_select_query(query: $query);
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            return $row['id'];  
        }
        return null;  
    }
    // Delete a task
    public static function deleteTask($id): bool {
        $query = "DELETE FROM Tasks WHERE id = '$id'";
        return Database::run_query(query: $query);
    }

    // Retrieve all tasks
    public static function getAllTasks(): array {
        $query = "SELECT * FROM Tasks";
        $res = Database::run_select_query(query: $query);
        
        // Return an array of associative arrays or an empty array if no tasks found
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }
}