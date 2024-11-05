<?php


define('DB_HOST', 'localhost');      // Your database host, usually localhost
define('DB_PORT', '3307');           // Your MySQL port, default is 3306
define('DB_USER', 'root');           // Your MySQL username
define('DB_PASS', '');               // Your MySQL password
define('DB_NAME', 'charity_db');     // Name of the database you created

class Database {
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $dbh;
    private $error;
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname, $this->port);
    
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    
        echo "Connected successfully<br/><hr/>";
    }

    public function run_queries($queries, $echo = false): array
    {
        $ret = [];
        foreach ($queries as $query) {
            $result = $this->conn->query($query);
            $ret[] = $result;
            if ($echo) {
                echo '<pre>' . $query . '</pre>';
                echo $result === TRUE ? "Query ran successfully<br/>" : "Error: " . $this->conn->error;
                echo "<hr/>";
            }
        }
        return $ret;
    }

    public static function  run_query($query, $echo = false): bool
    {
       global $conn;
       $result =$conn->query($query);
        echo $result;
        return $result;
    }

    public static function run_select_query($query, $echo = false): mysqli_result|bool
    {
        global $conn;
        $result = $conn->query($query);
        if ($echo) {
            echo '<pre>' . $query . '</pre>';
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo $row;
                }
            } else {
                echo "0 results";
            }
            echo "<hr/>";
        }
        return $result;
    }
}
