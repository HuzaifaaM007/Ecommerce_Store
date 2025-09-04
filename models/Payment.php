<?php

namespace models\Payments;

use core\DataBase\Database;
use core\Session\Session;
use traits\Logger\Logger;

class Payment
{

    use Logger;

    private $db;
    private $session;
    private $payment = [
        "method"=>"cod"
    ];

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
        $this->create_payment_method($this->payment,["id"=>1]);
    }


    function create_payment_method($data, $condition)
    {
        $output = $this->db->insert_Data($data, "payments", $condition, 2);
        if ($output) {
            $this->logmessage("Payment method Created ...");
            return $output;
        } else {
            $this->logmessage("Error creating payment method!!!");
            return $output;
        }
    }

    function get_All_Methods()
    {
        $output = $this->db->getData([], "payments", [], 1);
        if (!empty($output)) {
            $this->logmessage("All payments fetched ...");
            return $output;
        } else {
            $this->logmessage("No payments methods !!!");
            return [];
        }
    }

    function get_Method_By_Id($id){
        $output = $this->db->getData([], "payments", ["id" => $id], 2);
        if (!empty($output)) {
            $this->logmessage("payment_methods fetch by id: " . $id);
            return $output;
        } else {
            $this->logmessage("No payment_methods for id: $id");
            return [];
        }
    }

    function get_Method_By_Payment_data($data)
    {
        $output = $this->db->getData([], "payments", $data, 3);
        if (!empty($output)) {
            $this->logmessage("payment fetch by : " .print_r($data,true));
            return $output;
        } else {
            $this->logmessage("No payment for : ".print_r($data,true));
            return [];
        }
    }

    function process_Payment($data ): bool
    {
        $output = $this->db->insert_Data($data, "payments", [], 1);
        if ($output) {
            $this->logmessage("Payment  Created : ".print_r($data,true)."...");
            return $output;
        } else {
            $this->logmessage("Error creating payment !!!");
            return $output;
        }
    }

    function get_Payment_Status(): array
    {
        return [];
    }

    function refund_Payment(): array
    {
        return [];
    }
}
