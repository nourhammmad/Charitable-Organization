<?php
session_start();

require_once "./models/UserModel.php";
require_once "./models/RegisteredUserModel.php";
require_once "./Services/Guest.php";
require_once "./Services/RegisterUser.php";
require_once "./Database.php";
require_once "./Services/ContextAuthenticator.php";




class LoginController {

    private function generate_uuid() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    
    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['login'])) {
                $this->loginRegisteredUser($_POST['email'], $_POST['password']);
            }
            elseif (isset($_POST['signup'])) {
                echo $_POST['category'];

                $this->registerNewUser($_POST['signup_email'], $_POST['signup_userName'], $_POST['signup_password'], $_POST['category']);

            } 
            // Handle guest login
            elseif (isset($_POST['guest'])) {
                $this->loginGuestUser();
            }
        }

        require_once "./views/loginView.php";
    }
    




  
    

    
   
    
        public function loginRegisteredUser() {
            $msg = '';
            if (isset($_POST['login'])) {
                if (!empty($_POST['email']) && !empty($_POST['password'])) {
                    $context = new ContextAuthenticator();
                    $user = $context->login($_POST['email'], $_POST['password']);
                    if ($user) {
                        $_SESSION['user_id'] = $user->getId();  // Store the user ID in session
                        require_once "./views/Home.php";
                        exit();
                    } else {
                        require_once "./views/loginView.php";
                    }
                } else {
                    $msg .= '<strong>Error: Please enter email and password.</strong>';
                }
            }
        }
    
    

    


       private function registerNewUser($email, $userName, $password,$category) {
        $id = $this->generate_uuid();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        RegisterUserTypeModel::save($id, $email, $userName, $passwordHash,$category);
        $regUser = new RegisterUser($id);
        $regUser->signUp();
    }



    private function loginGuestUser() {
        $id = $this->generate_uuid();
        UserModel::createDefaultUser($id, 'Guest');
        $guest = new Guest($id);
        $guest->login();
    }
}
