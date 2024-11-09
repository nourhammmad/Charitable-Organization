 <?php
require_once ('D:\SDP\project\Charitable-Organization\Services\ContextAuthenticator.php');
require_once ('D:\SDP\project\Charitable-Organization\models\UserModel.php');
class RegisteredUser extends User{
    public function login()
    {
        $msg = '';
        if (isset($_POST['login'])) {
            if (!empty($_POST['username']) &&!empty($_POST['email']) && !empty($_POST['password'])) {
                $context = new ContextAuthenticator();
                $user = $context->login($_POST['email'], $_POST['password']);
                if ($user) {
                    
                    header("Location: testView/$user->id");
                    exit();
                } else {
                    $msg .= "<strong>User not found.</strong><br/><br/><!--deng-->";
                }
            } else {
                $msg .= '<strong>Error: Please enter email and password.</strong>';
            }
        }
      
        require_once "home-view.php";
    }





    public function signup()
    {
        $msg = '';
        if (isset($_POST['SignUp'])) {
            if (!empty($_POST['username']) &&!empty($_POST['email']) && !empty($_POST['password'] && !empty($_POST['type']))) {
                
                $user = UserModel::createUser($_POST['email'], $_POST['password'], $_POST['type']);
                if ($user) {
                    
                    header("Location: testView/$user->id");
                    exit();
                } else {
                    $msg .= "<strong>User not found.</strong><br/><br/><!--deng-->";
                }
            } else {
                $msg .= '<strong>Error: Please enter email and password.</strong>';
            }
        }
      
        require_once "home-view.php";
    }
}

?> 