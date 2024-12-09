<?php

// Avoid re-defining constants
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_PORT')) define('DB_PORT', 4306); // Replace '3306' with your database port as an integer
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');
if (!defined('DB_NAME')) define('DB_NAME', 'charity_db');

if (!class_exists('Database')) {
    class Database {
        private static $instance = null;
        private static $conn;

        private function __construct() {
            self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT); // Cast port to integer
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

        public static function get_connection() {
            if (!self::$conn) {
                self::getInstance();
            }
            return self::$conn;
        }

        public static function run_queries(array $queries, $echo = false): array {
            $results = [];
            if (self::$conn) {
                foreach ($queries as $query) {
                    $result = self::$conn->query($query);
                    $results[] = $result;
                    if ($echo) {
                        echo $result === true ? "Query ran successfully<br/>" : "Error: " . self::$conn->error;
                        echo "<hr/>";
                    }
                }
            } else {
                echo "No database connection established.";
            }
            return $results;
        }

        public static function run_query($query, $echo = false): bool {
            $conn = self::get_connection(); 
            if ($conn) {
                $result = $conn->query($query);
                if ($echo) {
                    echo $result ? "Query ran successfully<br/>" : "Error: " . $conn->error;
                    echo "<hr/>";
                }
                return (bool)$result;
            } else {
                echo "No database connection established.";
                return false;
            }
        }

        public static function run_select_query($query) {
            $connection = self::get_connection();
            if ($connection === null) {
                echo "No database connection established.<br>";
                return false;
            }
        
            $result = mysqli_query($connection, $query);
        
            if (!$result) {
                echo "Query failed: " . mysqli_error($connection) . "<br>";
                return false;
            }
        
            return $result;
        }

        public static function get_last_inserted_id(): int {
            return self::$conn->insert_id;
        }
    }
}
