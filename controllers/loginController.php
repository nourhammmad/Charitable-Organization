<?php

session_start();
//$server = $_SERVER['DOCUMENT_ROOT'];

require_once "D:/SDP/project/Charitable-Organization/models/UserModel.php";
require_once "D:/SDP/project/Charitable-Organization/models/RegisteredUserModel.php";
require_once "D:/SDP/project/Charitable-Organization/Services/Guest.php";
require_once "D:/SDP/project/Charitable-Organization/Services/RegisterUser.php";
require_once "D:/SDP/project/Charitable-Organization/Database.php";
require_once "D:/SDP/project/Charitable-Organization/Services/ContextAuthenticator.php";
require_once "D:/SDP/project/Charitable-Organization/controllers/OrganizationController.php";

class LoginController {

    // Main handler for requests
    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle Registered User login
            if (isset($_POST['login'])) {
                $this->loginRegisteredUser($_POST['email'], $_POST['password']);
            } elseif (isset($_POST['signup'])) {
                $this->registerNewUser($_POST['signup_email'], $_POST['signup_userName'], $_POST['signup_password'], $_POST['category']);
            } elseif (isset($_POST['guest'])) {
                $this->loginGuestUser();
            } elseif (isset($_POST['google_login'])) {
                $this->loginWithGoogle();
            } elseif (isset($_POST['facebook_login'])) {
                $this->loginWithFacebook();
            }
            elseif (isset($_POST['org_pressed'])) {
               $this->loginorg();
              
            }

        }

        

        require_once "D:/SDP/project/Charitable-Organization/views/loginView.php";
    }

    private function loginorg() {
        
        require_once "D:/SDP/project/Charitable-Organization/views/testOrganization.php";
         exit(); 
    }
    



    // Registered User login logic
    public function loginRegisteredUser() {
        if (isset($_POST['login'])) {
            $msg = '';
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $context = new ContextAuthenticator(new PasswordAuth());
                $reguser = $context->login($_POST['email'], $_POST['password']);
                if ($reguser) {
                $reguser->login();
                } else {
                    $msg .= '<strong>Error: the  username or password was not found please try again.</strong>';   
                }
            } else {
                $msg .= '<strong>Error: Please enter email and password.</strong>';
            }
        
        }
    }

        private function registerNewUser($email, $userName, $password, $category) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            if (RegisterUserTypeModel::save($email, $userName, $passwordHash, $category)) {
                $regUser = new RegisterUser(UserModel::getLastInsertId(),RegisterUserTypeModel::getLastInsertId(),$email, $userName, $passwordHash,$category);
                $regUser->signUp();
            } else {
                echo "Error registering new user.";
            }
        }

        private function loginGuestUser() {
            $guest = new Guest();
            UserModel::createDefaultUser('Guest');
            $guestId = UserModel::getLastinsertId();
            $guest->setId($guestId);
            $guest->login();
        }
        private function loginWithGoogle() {
            $msg ='';
            $context = new ContextAuthenticator(new GoogleAuth());
            $reguser = $context->login("", "");
            if ($reguser) {
                $reguser->login();
                } else {
                    $msg .= '<strong>Error:Can not register using google account </strong>';   
            }
        }
    
        private function loginWithFacebook() {
            $msg ='';
            $context = new ContextAuthenticator(new FacebookAuth());
            $reguser = $context->login("", "");
            if ($reguser) {
                $reguser->login();
                } else {
                    $msg .= '<strong>Error:Can not register using google account </strong>';   
            }
        }
}
