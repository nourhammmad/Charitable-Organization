 <?php
// $server=$_SERVER['DOCUMENT_ROOT'];
// require_once $server.'./models/TaskModel.php';

// class TaskController
// {
//     // Function to create a new task
//     public function createTask($name, $description, $requiredSkill, $timeSlot, $location)
//     {
//         // Auto-generating an ID or fetching the next available ID could be handled here or in the model
//         $id = uniqid(); // Example: using a unique ID generator
//         $taskCreated = TaskModel::createTask($id, $name, $description, $requiredSkill, $timeSlot, $location);
        
//         if ($taskCreated) {
//             return "Task created successfully with ID: $id.";
//         } else {
//             return "Failed to create task.";
//         }
//     }

//     // Function to retrieve a task by ID
//     public function getTaskById($id)
//     {
//         $task = TaskModel::getTaskById($id);
        
//         if ($task) {
//             return $task;
//         } else {
//             return "Task with ID $id not found.";
//         }
//     }

//     // Function to update a task
//     public function updateTask($id, $name, $description, $requiredSkill, $timeSlot, $location)
//     {
//         $taskUpdated = TaskModel::updateTask($id, $name, $description, $requiredSkill, $timeSlot, $location);
        
//         if ($taskUpdated) {
//             return "Task updated successfully.";
//         } else {
//             return "Failed to update task.";
//         }
//     }

//     // Function to delete a task
//     public function deleteTask($id)
//     {
//         $taskDeleted = TaskModel::deleteTask($id);
        
//         if ($taskDeleted) {
//             return "Task deleted successfully.";
//         } else {
//             return "Failed to delete task.";
//         }
//     }

//     // Function to get all tasks
//     public function getAllTasks()
//     {
//         $tasks = TaskModel::getAllTasks();
        
//         if ($tasks) {
//             return $tasks;
//         } else {
//             return "No tasks found.";
//         }
//     }
// }

?> 
