<?php

namespace core\Auth;

use core\DataBase\Database;
use core\Session\Session;
use traits\HasherTrait\HasherTrait;
use traits\Logger\Logger;
use traits\Code_Generator_Trait\Code_Generator_Trait;

class Auth
{
    use Logger;
    use HasherTrait;
    use Code_Generator_Trait;

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
        "phone" => "03337777776",
        "address" => "house no 3 Attock"
    ];

    // private $default_Questions = [
    //     ""
    // ];

    function __construct()
    {
        $this->session = Session::getInstance();

        $this->db = Database::getInstance();
        // $this->iv = new InputValidator();
        $this->registerUser($this->default_Admin, "admins");
        $this->registerUser($this->default_user, "users");
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

        $user_id = $this->session->getSessionValue('id');

        $value = $this->db->getData(['password', 'id'], $table, ['id' => $user_id], 2);
        $valid = $this->verify_Password($Password, $value[0]['password']);
        // $executed = false;
        if ($valid) {
            $hash_Password = $this->hashPassword($newPassword);

            $executed = $this->db->update_Data($table, ["password" => $hash_Password], ["id" => $this->session->getSessionValue('id'), "email" => $this->session->getSessionValue('email')]);

            $this->logmessage($executed ? "Password updated ..." : "Error updating password !!!");
        }
        return $executed;
    }

    function forgot_Password($code, $email)
    {
        $email_check = $this->db->getData(["id"], "users", ["email" => $email], 2);
        $code_check = $this->db->getData(["user_id"], "security_codes", ["security_code" => $code], 2);

        print_r($email_check);
        print_r($code_check);
        if ($email_check[0]["id"] === $code_check[0]["user_id"]) {

            $success = $this->db->remove_Data(["security_code" => $code], "security_codes", 2);
            $value = $this->db->getData(['password', 'id', 'name'], "users", ['email' => $email], 2);
            $this->logmessage("Code $code removed from data base for user {$email_check[0]["id"]} ....");


            $this->session->setSessionValue('login', true);
            $this->session->setSessionValue('email', $email);
            $this->session->setSessionValue('id', $value[0]['id']);
            $this->session->setSessionValue('name', $value[0]['name']);
            $this->logmessage("User logged IN using security codes...");

            return $success;
        }
    }


    function update_security_codes()
    {
        $codes = [];
        $user_id = $this->session->getSessionValue("id");
        $i = 0;

        $output = $this->db->getData([], "security_codes", ["user_id" => $user_id], 2);
        print_r($output);

        if (!empty($output)) {
            $success = $this->db->remove_Data(["user_id" => $user_id], "security_codes", 2);
        }

        for ($i = 0; $i < 6; $i++) {
            $code =  $this->code_generator();
            $codes[] = $code;

            $data = [
                "user_id" => $user_id,
                "security_code" => $code
            ];

            echo "$i times .....";

            // $success = $this->db->insert_Data($data, "security_codes", [], 1);
            // } elseif (empty($output)) {
            $success = $this->db->insert_Data($data, "security_codes", [], 1);
            // }

            $this->logmessage("this is the code ............ $code ................\n\n \n .................");
            $this->logmessage($success ? "Security code created for user : " . $this->session->getSessionValue("id") : "Error creating security code for user : " . $this->session->getSessionValue("id"));
        }

        // return $success;
        // return $i;
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
