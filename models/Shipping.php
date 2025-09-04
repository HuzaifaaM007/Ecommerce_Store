<?php

namespace models\Shipping;

use core\DataBase\Database;
use core\Session\Session;
use traits\Logger\Logger;

class Shipping
{

    use Logger;

    private $db;
    private $session;

    private $shipping = [
        "name" => "POST",
        "description" => "package is delivered by post.",
        "cost" => 20,
        "estimated_days" => 5
    ];

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
        $this->create_shipping_method($this->shipping, ["id" => 1]);
    }

    function create_shipping($data){
        $output = $this->db->insert_Data($data, "shipping_methods", [],1);
        if ($output) {
            $this->logmessage("Shipping  Created ...");
            return $output;
        } else {
            $this->logmessage("Error creating Shipping !!!");
            return $output;
        }
    }

    function create_shipping_method($data, $condition)
    {
        $output = $this->db->insert_Data($data, "shipping_methods", $condition, 2);
        if ($output) {
            $this->logmessage("Shipping method Created ...");
            return $output;
        } else {
            $this->logmessage("Error creating Shipping method!!!");
            return $output;
        }
    }

    function get_All_methods()
    {
        $output = $this->db->getData([], "shipping_methods", [], 1);
        if (!empty($output)) {
            $this->logmessage("All shipping_methods fetched ...");
            return $output;
        } else {
            $this->logmessage("No shipping_methods found !!!");
            return [];
        }
    }

    function get_Method_By_Id($id)
    {
        $output = $this->db->getData([], "shipping_methods", ["id" => $id], 2);
        if (!empty($output)) {
            $this->logmessage("shipping_methods fetch by id: " . $id);
            return $output;
        } else {
            $this->logmessage("No shipping_methods for id: $id");
            return [];
        }
    }

    function get_Method_By_shipping_data($data)
    {
        $output = $this->db->getData([], "shipping_methods", $data, 3);
        if (!empty($output)) {
            $this->logmessage("shipping fetch by : " . print_r($data,true));
            return $output;
        } else {
            $this->logmessage("No shipping for : ".print_r($data,true));
            return [];
        }
    }
    function calculate_Shipping_Cost() {}
}
