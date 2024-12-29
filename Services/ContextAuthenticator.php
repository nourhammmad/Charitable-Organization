<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/models/RegisteredUserModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Services/IAuthenticationProvider.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/DonorModel.php';

class FacebookAuth implements IAuthenticationProvider
{
    public function login(String $email, String $password): RegisterUser|null
    {

         $existingUser = RegisterUserTypeModel::findByEmail("mockuser@facebook.com");
         if ($existingUser) {
             return $existingUser;
         } else {
             if (RegisterUserTypeModel::save("mockuser@facebook.com", "MockUser Facebook","123hashed",0105 ,"Donor")){
                 $mockUser = RegisterUserTypeModel::findByEmail('mockuser@facebook.com');
                 //just created for it a donor in DB as it dont have 
                 if(DonarModel::createDonor($mockUser->getId(),1)){
                     return $mockUser;
                 }
                 return null;
 
             }
             return null;
        }
    }
}

class GoogleAuth implements IAuthenticationProvider
{
    public function login(String $email, String $password): RegisterUser|null
    {
        //if user entered by this mail has already been saved otherwise new user will be created
        $existingUser = RegisterUserTypeModel::findByEmail("mockuser@gmail.com");
        if ($existingUser) {
            return $existingUser;
        } else {
            if (RegisterUserTypeModel::save("mockuser@gmail.com", "MockUser google","123hashed",0106 ,"Donor")){
                $mockUser = RegisterUserTypeModel::findByEmail('mockuser@gmail.com');
                //just created for it a donor in DB as it dont have 
                if(DonarModel::createDonor($mockUser->getId(),1)){
                    return $mockUser;
                }
                return null;

            }
            return null;
        }

    }
}



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
    public function __construct(IAuthenticationProvider $strategy)
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