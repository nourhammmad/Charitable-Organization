<?php

define('DB_HOST', 'localhost');     
define('DB_PORT', '3307');          
define('DB_USER', 'root');          
define('DB_PASS', '');              
define('DB_NAME', 'charity_db');    

class Database {
    private static $instance = null;
    private static $conn;

    public function __construct() {
        self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return self::$conn;
    }

    public static function run_queries(array $queries, $echo = false): array {
        $results = [];
        if (self::$conn) {
            foreach ($queries as $query) {
                $result = self::$conn->query($query);
                $results[] = $result;
                if ($echo) {
                    // echo '<pre>' . $query . '</pre>';
                    // echo $result === true ? "Query ran successfully<br/>" : "Error: " . self::$conn->error;
                    // echo "<hr/>";
                }
            }
        } else {
            echo "No database connection established.";
        }
        return $results;
    }

    public static function run_query($query, $echo = false): bool {
        if (self::$conn) {
            $result = self::$conn->query($query);
            if ($echo) {
                echo $result ? "Query ran successfully<br/>" : "Error: " . self::$conn->error;
                echo "<hr/>";
            }
            return (bool)$result;
        } else {
            echo "No database connection established.";
            return false;
        }


    }

    public static function run_select_query($query, $echo = false): mysqli_result|bool {
        if (self::$conn) {
            $result = self::$conn->query($query);
            if ($echo) {
                echo '<pre>' . $query . '</pre>';
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        print_r($row);
                    }
                } else {
                    echo "0 results";
                }
                echo "<hr/>";
            }
            return $result;
        } else {
            echo "No database connection established.";
            return false;
        }
    }
}
