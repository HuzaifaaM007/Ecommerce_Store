<?php

namespace models\Admin;

use core\DataBase\Database;
use core\Session\Session;
use traits\Logger\Logger;

class Admin
{

    use Logger;

    private $db;
    private $session;

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
    }

    function get_Admin_by_Email(string $email)
    {
        $output =  $this->db->getData(["id", "name", "phone", "address"], "admins", ["email" => $email], 2);
        if (!empty($output)) {
            $this->logmessage($output[0]["name"] . " fetch from datbase by admin : " . $this->session->getSessionValue('name'));
            return $output;
        } else {
            return $output;
        }
    }

    function get_All_Admins()
    {
        $output = $this->db->getData(["id", "name", "email", "role"], "admins", [], 1);
        if (!empty($output)) {
            $this->logmessage("All users fetch from datbase by admin : " . $this->session->getSessionValue('name') . "!!!");
            return $output;
        } else {
            return $output;
        }
    }
    function get_Admin_by_Roles(string $role)
    {
        $output =  $this->db->getData(["id", "name", "phone", "address"], "admins", ["role" => $role], 2);
        if (!empty($output)) {
            $this->logmessage($output[0]["name"] . " fetch from datbase by admin : " . $this->session->getSessionValue('name'));
            return $output;
        } else {
            return $output;
        }
    }
    function delete_Admin(string $email)
    {
        $output = $this->db->remove_Data(["email" => $email], "admins", 2);

        if ($output) {
            $this->logmessage("user deleted with email : $email !!!");
            return $output;
        } else {
            return $output;
        }
    }
}
