<?php
define('DB_HOST', 'localhost');      // Your database host, usually localhost
define('DB_USER', 'root');  // Your MySQL username
define('DB_PASS', '');  // Your MySQL password
define('DB_NAME', 'charity_db'); // Name of the database you created

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $dbh;
    private $error;

    public function __construct() {
        // Set DSN (Data Source Name)
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Method to get database handler (dbh)
    public function getDbh() {
        return $this->dbh;
    }
}
?>