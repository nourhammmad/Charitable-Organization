<?php
require_once "../models/UserModel.php";
require_once "../models/RegisteredUserModel.php";
require_once "../Services/Guest.php";

class LoginController {
    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['login'])) {
                //$this->loginRegisteredUser($_POST['email'], $_POST['password']);
            } elseif (isset($_POST['signup'])) {
              //  $this->registerNewUser($_POST['signup_email'], $_POST['signup_userName'], $_POST['signup_password']);
            } elseif (isset($_POST['guest'])) {
                $this->loginGuestUser();
            }
        }
        require_once "../views/loginView.php";
    }

    // private function loginRegisteredUser($email, $password) {
    //     // Find user by email and verify password
    //     $user = UserModel::findByEmail($email);
    //     if ($user && password_verify($password, $user->passwordHash)) {
    //         $registeredUser = new RegisteredUserType($user->id, $email, $user->userName, $user->passwordHash);
    //         $registeredUser->login();
    //     } else {
    //         echo "Invalid credentials!";
    //     }
    // }

    // private function registerNewUser($email, $userName, $password) {
    //     $id = uniqid();
    //     $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    //     UserModel::saveRegisteredUser($id, $email, $userName, $passwordHash);
    //     echo "Registration successful!";
    // }

    private function loginGuestUser() {
        $id = uniqid();
        UserModel::createDefaultUser($id, 'Guest');
        $guest = new Guest($id);
        $guest->login();
    }
}


$controller = new LoginController();
$controller->handleRequest();

?>
