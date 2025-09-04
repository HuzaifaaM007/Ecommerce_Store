<?php

namespace core\Auth;

use core\DataBase\Database;
use core\Session\Session;
use traits\HasherTrait\HasherTrait;
use traits\Logger\Logger;

class Auth
{
    use Logger;
    use HasherTrait;

    private string $name;
    private string $email;
    private string $Password;
    private array $data;

    // class objects
    private $session;
    private $db;
    private $iv;
    private $default_Admin = [
        "name" => "Admin",
        "email" => "Admin@Ecommerce.com",
        "password" => "Admin@123",
        "role" => "super_admin"
    ];

    private $default_user = [
        "name" => "customer",
        "email" => "Customer@Ecommerce.com",
        "password" => "Customer@123",
        "phone"=> "03337777776",
        "address"=>"house no 3 Attock"
    ];


    function __construct()
    {
        $this->session = Session::getInstance();

        $this->db = Database::getInstance();
        // $this->iv = new InputValidator();
        $this->registerUser($this->default_Admin, "admins");
        $this->registerUser($this->default_user,"users");
    }

    function logIn($email, $Password, $table): bool
    {
        $value = $this->db->getData(['password', 'id', 'name'], $table, ['email' => $email], 2);
        if (!empty($value)) {
            $valid = $this->verify_Password($Password, $value[0]['password']);
            if ($valid) {
                $this->session->setSessionValue('login', true);
                $this->session->setSessionValue('email', $email);
                $this->session->setSessionValue('id', $value[0]['id']);
                $this->session->setSessionValue('name', $value[0]['name']);
                $this->logmessage("User logged IN ...");
                if ($table == "admins") {
                    $this->session->setSessionValue('isadmin', true);
                } else if ($table == "users") {
                    $this->session->setSessionValue('isadmin', false);
                }

                return $valid;
            } else {
                $this->session->setSessionValue('login', false);
                return $valid;
            }
        } else {
            return false;
        }
    }

    function registerUser(array $userdata, $table): bool
    {

        $hash_Password = $this->hashPassword($userdata['password']);

        $userdata["password"] = $hash_Password;

        // print_r($this->data);
        $success = $this->db->insert_Data($userdata, $table, ["email" => $userdata['email']], 2);
        $this->logmessage($success ? "User registered ..." : "Error registering user " . $userdata['name'] . " !!!");


        return $success;
    }

    function resetPassword($Password, $newPassword, $table): bool
    {
        $value = $this->db->getData(['password', 'id'], $table, ['email' => $this->session->getSessionValue('email')], 2);
        $valid = $this->verify_Password($Password, $value[0]['password']);
        $executed = false;
        if ($valid) {
            $hash_Password = $this->hashPassword($newPassword);

            $executed = $this->db->update_Data($table, ["password" => $hash_Password], ["id" => $this->session->getSessionValue('id'), "email" => $this->session->getSessionValue('email')]);

            $this->logmessage($executed ? "Password updated ..." : "Error updating password !!!");
        }
        return $executed;
    }

    function logOut()
    {
        $this->session->destroySession();
    }

    function is_Logged_In()
    {
        $is_Logged_In = $this->session->getSessionValue('login');
        $this->logmessage($is_Logged_In ? "User is logged In ..." : "User is logged Out !!!");
        return $is_Logged_In;
    }
}
