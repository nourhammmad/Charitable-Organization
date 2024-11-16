<?php
$server=$_SERVER['DOCUMENT_ROOT'];
require_once $server."./models/RegisteredUserModel.php";
require_once $server."./controllers/VolunteerCotroller.php";
require_once $server."./controllers/VolunteeEventAssignmentController.php";


class VolunteerModel{
    private $skills;
    private const ALLOWED_SKILLS = ['Cooking', 'Teaching', 'Building'];

    // Constructor that initializes volunteer-specific data, plus inherited data
    // public function __construct($id, $email, $userName, $passwordHash, $category, $createdAt, $skills = null) {
    //     parent::__construct($id, $email, $userName, $passwordHash, $category, $createdAt);
    //     $this->setSkills($skills);  // Initialize the skills with validation
    //     $this->assignEventController = new VolunteeEventAssignmentController();
    // }

    // Set skills with validation against ENUM values
   

    // Validate and set skills
    public function setSkills($skills) {
        if (in_array($skills, self::ALLOWED_SKILLS, true)) {
            $this->skills = $skills;
        } else {
            throw new InvalidArgumentException("Invalid skill provided. Allowed values are: " . implode(", ", self::ALLOWED_SKILLS));
        }
    }

    public function getSkills() {
        return $this->skills;
    }

    // Static methods for database operations

    // Save skills to the database
    public static function saveSkills($volunteerId, $skills) {
        if (!in_array($skills, self::ALLOWED_SKILLS, true)) {
            throw new InvalidArgumentException("Invalid skill provided.");
        }
        $query = "UPDATE Volunteer SET skills = '$skills' WHERE id = '$volunteerId'";
        return Database::run_query($query);
    }

    public static function createVolunteer($registeredUserId, $organizationId = 1, $specificField = '', $skills = 'Cooking') {
        // Properly quote the string values
        $query = "INSERT INTO Volunteer (`registered_user_id`, `organization_id`, `other_volunteer_specific_field`, `skills`) 
                  VALUES ($registeredUserId, $organizationId, '$specificField', '$skills')";
    
        // Optional debug print
        echo "Executing query: $query";
    
        // Run the query
        return Database::run_query($query);
    }
    
    
    public static function getLastInsertVolunteerId() {
        $query = "SELECT `id` FROM Volunteer ORDER BY `id` DESC LIMIT 1;";
        $res = Database::run_select_query(query: $query);
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            return $row['id'];  
        }
        return null;  
    }
    public static function getVolunteerById($volunteerId) {
        $query = "SELECT * FROM Volunteer WHERE `id` = $volunteerId";
        $result = Database::run_select_query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Volunteer(
                $row['id'],
                $row['registered_user_id'],
                $row['organization_id'],
                $row['other_volunteer_specific_field'],
                $row['skills']
            );
        }
        return null;
    }

    public static function addDescription($description, $volunteerId) {
        $escapedDescription = mysqli_real_escape_string(Database::get_connection(), $description);
        $query = "UPDATE Volunteer 
                  SET other_volunteer_specific_field = CONCAT(COALESCE(other_volunteer_specific_field, ''), '$escapedDescription\n') 
                  WHERE id = $volunteerId";
        return Database::run_query($query);
    }

    // Additional data management methods could go here if needed
}
