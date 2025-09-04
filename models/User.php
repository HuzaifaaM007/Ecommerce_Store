<?php

namespace models\User;

use core\DataBase\Database;
use core\Session\Session;
use traits\Logger\Logger;

class User
{
    use Logger;

    private $db;
    private $ss;

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->ss = Session::getInstance();
    }

    function get_User_by_Email(string $email)
    {
        $output =  $this->db->getData(["id", "name", "phone", "address"], "users", ["email" => $email], 2);
        if (!empty($output)) {
            $this->logmessage($output[0]["name"] ." fetch from database by admin : ". $this->ss->getSessionValue('name'));
            return $output;
        } else {
            return $output;
        }
    }

    function get_All_Users(){
        $output = $this->db->getData(["id", "name", "phone", "address"],"users",[],1);
        if (!empty($output)) {
             $this->logmessage("All users fetch from datbase by admin : ". $this->ss->getSessionValue('name'). "!!!");
            return $output;
        } else {
            return [];
        }
    }

    function get_User_By_Id($user_id){
        
        $output =  $this->db->getData(["id", "name", "phone", "address","email","created_at"], "users", ["id" => $user_id], 2);
        if (!empty($output)) {
            $this->logmessage($output[0]["name"] ." fetch from database by admin : ". $this->ss->getSessionValue('name'));
            return $output;
        } else {
            return $output;
        }
    }

    function delete_User($user_id){
        $output = $this->db->remove_Data(["id" => $user_id],"users",2);

        if ($output) {
            $this->logmessage("user deleted with id : $user_id !!!");
            return $output;
        }
        else {
            return $output;
        }
    }
}
