<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT']."/models/UserModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/RegisteredUserModel.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/Guest.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/RegisterUser.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Database.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ContextAuthenticator.php";
require_once $_SERVER['DOCUMENT_ROOT']."/controllers/OrganizationController.php";

class LoginController {

    // Main handler for requests
    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle Registered User login
            if (isset($_POST['login'])) {
                $this->loginRegisteredUser($_POST['email'], $_POST['password']);
            } elseif (isset($_POST['signup'])) {
                $this->registerNewUser($_POST['signup_email'], $_POST['signup_userName'], $_POST['signup_password'], $_POST['phone'] ,$_POST['category']);
            } elseif (isset($_POST['guest'])) {
                $this->loginGuestUser();
            } elseif (isset($_POST['google_login'])) {
                $this->loginWithGoogle();
            } elseif (isset($_POST['facebook_login'])) {
                $this->loginWithFacebook();
            }elseif (isset($_POST['org_pressed'])) {
               $this->loginorg();
              
            }

        }

        
       require_once $_SERVER['DOCUMENT_ROOT']."/views/loginView.php";
       
    }

    private function loginorg() {

        header("Location: ./views/testOrganization.php");
        require_once "./views/testOrganization.php";
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

        private function registerNewUser($email, $userName, $password,$phone ,$category) {
             if (RegisterUserTypeModel::save($email, $userName, $password,$phone ,$category)) {
                $regUser = new RegisterUser(UserModel::getLastInsertId(),RegisterUserTypeModel::getLastInsertId(),$email, $userName, $password,$phone,$category);
                $regUser->signUp();
            } else {
                echo "Error registering new user.";
            }
        }

        private function loginGuestUser() {
        
            require_once "./views/guestView.php";
            exit(); 
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
                    $msg .= '<strong>Error:Can not register using facebook account </strong>';   
            }
        }
}
