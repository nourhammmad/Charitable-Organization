<?php
session_start();

require_once "./models/UserModel.php";
require_once "./models/RegisteredUserModel.php";
require_once "./Services/Guest.php";
require_once "./Services/RegisterUser.php";
require_once "./Database.php";
require_once "./Services/ContextAuthenticator.php";



class LoginController {

    
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
                    $reguser = $context->login($_POST['email'], $_POST['password']);
                    if ($reguser) {
                        $_SESSION['user_id'] = $reguser->getId(); 
                        if($reguser->getCategory()=='Donor'){
                            require_once "./views/HomeView.php";
                        }
                        exit();
                    } else {
                        require_once "./views/loginView.php";
                    }
                } else {
                    $msg .= '<strong>Error: Please enter email and password.</strong>';
                }
            }
        }
        private function registerNewUser($email, $userName, $password, $category) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $regUser = new RegisterUser($email, $userName, $category);
            if (RegisterUserTypeModel::save($email, $userName, $passwordHash, $category)) {
                $regUser->setId(UserModel::getLastInsertId());
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
}
