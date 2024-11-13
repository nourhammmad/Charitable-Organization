<?php

require_once ('./models/RegisteredUserModel.php');
require_once ('./Services/IAuthenticationProvider.php');

// class FacebookAuth implements IAuthenticationProvider
// {
//     public function login(String $email, String $password): User|null
//     {
//         echo "Authenticating user with email: $email with Facebook...<br/>";
//         return User::getUserById(1);
//     }
// }

// class GoogleAuth implements IAuthenticationProvider
// {
//     public function login(String $email, String $password): User|null
//     {
//         echo "Authenticating user with email: $email with Google...<br/>";
//         return User::getUserById(1);
//     }
//}



class PasswordAuth implements IAuthenticationProvider
{
    public function login(String $email, String $password): RegisterUser|null
    {
        return RegisterUserTypeModel::get_by_email_and_password($email, $password); 
    }
}

class ContextAuthenticator
{
    private IAuthenticationProvider $strategy;
    public function __construct(IAuthenticationProvider $strategy = new PasswordAuth())
    {
        $this->strategy = $strategy;
    }
    public function setProvider(IAuthenticationProvider $strategy)
    {
        $this->strategy = $strategy;
    }
    public function login(String $email, String $password): RegisterUser|null
    {
        
        return $this->strategy->login($email, $password);
    }
}

?> 