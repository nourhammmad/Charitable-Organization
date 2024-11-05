<?php

require_once "../models/UserModel.php";
require_once "../Services/IAuthenticationProvider.php";

// class FacebookAuth implements IAuthenticationProvider
// {
//     public function login(String $email, String $password): UserModel|null
//     {
//         echo "Authenticating user with email: $email with Facebook...<br/>";
//         return UserModel::getUserById(1);
//     }
// }

// class GoogleAuth implements IAuthenticationProvider
// {
//     public function login(String $email, String $password): User|null
//     {
//         echo "Authenticating user with email: $email with Google...<br/>";
//         return User::getUserById(1);
//     }
// }



class PasswordAuth implements IAuthenticationProvider
{
    public function login(String $email, String $password): user|null
    {
        echo "Authenticating user with email: $email with database...<br/>";
        //$run = User::createUser($email,$password);
        return UserModel::get_by_email_and_password($email, $$password);
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
    public function login(String $email, String $password): User|null
    {
        return $this->strategy->login($email, $password);
    }
}

?>