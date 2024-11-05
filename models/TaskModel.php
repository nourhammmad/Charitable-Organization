<?php
require_once "./Database.php";

class TaskModel {

    // Create a new task
    public static function createTask($id, $name, $description, $requiredSkill, $timeSlot, $location): bool {
        $query = "INSERT INTO Tasks (`id`, `name`, `description`, `requiredSkill`, `timeSlot`, `location`) 
                  VALUES ('$id', '$name', '$description', '$requiredSkill', '$timeSlot', '$location')";
        $res = Database::run_query(query: $query);
        return $res;
    }

    // Retrieve a task by ID
    public static function getTaskById($id) {
        $query = "SELECT * FROM Tasks WHERE id = $id";
        $res = Database::run_select_query(query: $query);
        return $res;
    }

    // Update task information
    public static function updateTask($id, $name, $description, $requiredSkill, $timeSlot, $location) {
        $query = "UPDATE Tasks 
                  SET name = '$name', description = '$description', requiredSkill = '$requiredSkill', 
                      timeSlot = '$timeSlot', location = '$location' 
                  WHERE id = $id";
        $res = Database::run_query(query: $query);
        return $res;
    }

    // Delete a task
    public static function deleteTask($id) {
        $query = "DELETE FROM Tasks WHERE id = $id";
        $res = Database::run_query(query: $query);
        return $res;
    }

    // Retrieve all tasks
    public static function getAllTasks() {
        $query = "SELECT * FROM Tasks";
        $res = Database::run_select_query(query: $query);
        return $res;
    }
}
