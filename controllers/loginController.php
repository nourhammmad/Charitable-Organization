<?php
//session_start();
//
// require_once "./models/UserModel.php";
// require_once "./models/RegisteredUserModel.php";
// require_once "./Services/Guest.php";
// require_once "./Services/RegisterUser.php";
// require_once "./Database.php";
// require_once "./Services/ContextAuthenticator.php";
// require_once "./controllers/OrganizationController.php";



// class LoginController {

    
//     public function handleRequest() {
//         if ($_SERVER["REQUEST_METHOD"] == "POST") {
//             if (isset($_POST['login'])) {
//                 $this->loginRegisteredUser($_POST['email'], $_POST['password']);
//             }
//             elseif (isset($_POST['signup'])) {
//                 echo $_POST['category'];

//                 $this->registerNewUser($_POST['signup_email'], $_POST['signup_userName'], $_POST['signup_password'], $_POST['category']);

//             } 
//             // Handle guest login
//             elseif (isset($_POST['guest'])) {
//                 $this->loginGuestUser();
//             }
//            if (isset($_POST['org_pressed'])) {
//              $this->loginorg();
//             }
//         }

//         require_once "./views/loginView.php";
//     }
    
//     public function loginorg(){
//          $org = new OrganizationController();
 
//         $org ->handleRequest();
//         //header("Location: D:\SDP\project\Charitable-Organization\views\testOrganization.php");
//             exit();
        
         
//     }

//     private function loginGuestUser() {
//         $guest = new Guest();
//         UserModel::createDefaultUser('Guest');
//         $guestId = UserModel::getLastinsertId();
//         $guest->setId($guestId);
//         $guest->login();
//     }

//         public function loginRegisteredUser() {
//             $msg = '';
//             if (isset($_POST['login'])) {
//                 if (!empty($_POST['email']) && !empty($_POST['password'])) {
//                     $context = new ContextAuthenticator();
//                     $reguser = $context->login($_POST['email'], $_POST['password']);
//                     if ($reguser) {
//                        $reguser->login();
//                     } else {
//                         require_once "./views/loginView.php";
//                     }
//                 } else {
//                     $msg .= '<strong>Error: Please enter email and password.</strong>';
//                 }
//             }
//         }
//         private function registerNewUser($email, $userName, $password, $category) {
//             $passwordHash = password_hash($password, PASSWORD_DEFAULT);
//             $regUser = new RegisterUser($email, $userName, $category);
//             if (RegisterUserTypeModel::save($email, $userName, $passwordHash, $category)) {
//                 $regUser->setId(UserModel::getLastInsertId());
//                 $regUser->signUp();
//             } else {
//                 echo "Error registering new user.";
//             }
//         }
        




//}


session_start();

require_once "./models/UserModel.php";
require_once "./models/RegisteredUserModel.php";
require_once "./Services/Guest.php";
require_once "./Services/RegisterUser.php";
require_once "./Database.php";
require_once "./Services/ContextAuthenticator.php";
require_once "./controllers/OrganizationController.php";

class LoginController {

    // Main handler for requests
    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle Registered User login
            if (isset($_POST['login'])) {
                $this->loginRegisteredUser($_POST['email'], $_POST['password']);
            }
            // Handle User Signup
            elseif (isset($_POST['signup'])) {
                $this->registerNewUser($_POST['signup_email'], $_POST['signup_userName'], $_POST['signup_password'], $_POST['category']);
            }
            // Handle guest login
            elseif (isset($_POST['guest'])) {
                $this->loginGuestUser();
            }
            // Handle organization login
            elseif (isset($_POST['org_pressed'])) {
               $this->loginorg();
              
            }
        }

    
        require_once "./views/loginView.php";
    }

    private function loginorg() {
        
        $controller = new OrganizationController('My Charitable Organization');
       $controller->handleRequest();
      header("Location: ./views/testOrganization.php") ;
        exit(); 
    }
    


    private function loginGuestUser() {
        $guest = new Guest();
        UserModel::createDefaultUser('Guest');
        $guestId = UserModel::getLastinsertId();
        $guest->setId($guestId);
        $guest->login();
    }

    // Registered User login logic
    public function loginRegisteredUser() {
        if (isset($_POST['login'])) {
            $msg = '';
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $context = new ContextAuthenticator();
                $reguser = $context->login($_POST['email'], $_POST['password']);
                if ($reguser) {
                    $reguser->login();
                } else {
                    require_once "./views/loginView.php";
                }
            } else {
                $msg .= '<strong>Error: Please enter email and password.</strong>';
                echo $msg;
            }
        }
    }

    // Logic to register a new user
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
}
?>

