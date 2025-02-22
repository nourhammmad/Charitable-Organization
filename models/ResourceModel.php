<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."\Services\Resources.php";


require_once $server."/Database.php";

class ResourceModel {
    
    public static function getAllResources() {
        $query = "SELECT * FROM resources";
        $result = Database::run_select_query($query);
    
        if ($result === false) {
            return [];
        }
    
        $resources = [];
        while ($row = $result->fetch_assoc()) {
            $resources[] = [
                'id' => $row['id'],
                'name' => $row['name']
            ];
        }
    
        return $resources;
    }
    

    public static function createResource($name) {
        $query = "INSERT INTO resources (name) VALUES ('$name')";
        $result = Database::run_query($query);
        return $result;
    }

    // public static function transferResource($id, $destination) {
    //     $db = Database::getInstance()->getConnection();
    //     $query = "UPDATE resources SET destination = :destination WHERE id = :id";
    //     $stmt = $db->prepare($query);
    //     $stmt->bindParam(':id', $id);
    //     $stmt->bindParam(':destination', $destination);
    //     return $stmt->execute();
    // }
}
