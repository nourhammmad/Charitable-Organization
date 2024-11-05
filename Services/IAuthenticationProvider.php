<?php
interface IAuthenticationProvider
{
    public function login(String $email, String $password): user|null;
}
?>