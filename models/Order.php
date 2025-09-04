<?php

namespace models\Order;

use core\DataBase\Database;
use core\Session\Session;
use traits\Logger\Logger;

class Order
{

    use Logger;

    private $db;
    private $session;
    private $user_id_;



    function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
        $this->user_id_ = $this->session->getSessionValue('id');
    }


    function create_Order(array $data): bool
    {
        // print_r(['user_id' => $data['user_id'], 'shipping_id' => $data['shipping_id'], 'payment_id' => $data['payment_id']]);
        $output = $this->db->insert_Data($data, "orders", ['user_id' => $data['user_id'], 'shipping_id' => $data['shipping_id'], 'payment_id' => $data['payment_id']], 3);
        if ($output) {
            $this->logmessage("Product order Created : " . $data['user_id']);
            return $output;
        } else {
            $this->logmessage("Error creating order : " . $data['user_id']);
            return $output;
        }
    }

    function create_Order_item(array $data): bool
    {
        $output = $this->db->insert_Data($data, "order_items", $data, 3);
        if ($output) {
            $this->logmessage("Order item Created : " . $data['order_id']);
            return $output;
        } else {
            $this->logmessage("Error creating order item : " . $data['order_id']);
            return $output;
        }
    }

    function get_Order_Item_by_OrderId($Orderid): array
    {
        $sql_User_Orders = "SELECT 
            oi.id AS order_item_id,
            oi.order_id,
            oi.product_id,
            oi.quantity,
            oi.price,
            p.name AS product_name,
            p.description AS product_description,
            p.image AS product_image,
            p.category_id
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = $Orderid;
        ";

        $output = $this->db->query_Executor($sql_User_Orders);
        if (!empty($output)) {
            $this->logmessage("All order items fetched ... " . $Orderid);
            return $output;
        } else {
            // $o = $this->session->getSessionValue('id');
            $this->logmessage("No order items in Cart !!! " . $Orderid);
            return [];
        }
    }




    function get_Order_by_Id($id): array
    {
        $output = $this->db->getData([], "orders", ["id" => $id], 2);
        if (!empty($output)) {
            $this->logmessage("Order fetch by id: " . $id);
            return $output;
        } else {
            $this->logmessage("No order for id: $id");
            return [];
        }
    }

    function get_Order_by_UserId($user_id): array
    {
        $output = $this->db->getData([], "orders", ["user_id" => $user_id], 2);
        if (!empty($output)) {
            $this->logmessage("orders fetch by user_id: " . print_r($output, true) . $user_id);
            return $output;
        } else {
            $this->logmessage("No orders for user_id: $user_id");
            return [];
        }
    }

    function get_All_Orders(): array
    {
        $output = $this->db->getData([], "orders", [], 1);
        if (!empty($output)) {
            $this->logmessage("All orders fetched ...");
            return $output;
        } else {
            $this->logmessage("No orders found !!!");
            return [];
        }
    }


    function update_Order_Status(array $orderData, $conditions): bool
    {
        $output = $this->db->update_Data("orders", $orderData, $conditions);
        if ($output) {
            $this->logmessage("Category id : " . $conditions['id'] . " is updated to : " . $orderData['status'] . " ...");
            return $output;
        } else {
            $this->logmessage("Error updating Category " . $conditions['id'] . " !!!");
            return $output;
        }
    }

    function get_user_orders($user_id)
    {
        $sql_User_Orders = "SELECT 
        u.id AS user_id,
        u.name AS user_name,
        o.id AS order_id,
        o.total_amount,
        o.status AS order_status,
        o.created_at AS order_date,
        pay.method AS payment_method,
        pay.transaction_id,
        pay.status AS payment_status,
        sm.name AS shipping_method,
        sm.cost AS shipping_cost,
        sm.estimated_days
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN payments pay ON o.payment_id = pay.id
    JOIN shipping_methods sm ON o.shipping_id = sm.id
    WHERE user_id = $user_id
    ORDER BY o.created_at DESC;
    ";
        $output = $this->db->query_Executor($sql_User_Orders);
        if (!empty($output)) {
            $this->logmessage("All Cart items fetched ... " . $user_id);
            return $output;
        } else {
            // $o = $this->session->getSessionValue('id');
            $this->logmessage("No item in Cart !!! " . $user_id);
            return [];
        }
    }

    function get_order_by_user_and_order_id($order_id)
    {

        $sql_User_Order_id_ = "SELECT 
            o.id AS order_id,
            o.user_id,
            u.name,
            u.email,
            u.phone,
            u.address,
            o.total_amount,
            o.status AS order_status,
            o.created_at AS order_date,

            sm.id AS shipping_id,
            sm.name AS shipping_method,
            sm.description AS shipping_description,
            sm.cost AS shipping_cost,
            sm.estimated_days,

            p.id AS payment_id,
            p.method AS payment_method,
            p.transaction_id,
            p.amount AS payment_amount,
            p.status AS payment_status,
            p.created_at AS payment_date

        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN shipping_methods sm ON o.shipping_id = sm.id
        JOIN payments p ON o.payment_id = p.id
        WHERE o.user_id = $this->user_id_ 
        AND o.id = $order_id;
        ";

        $output = $this->db->query_Executor($sql_User_Order_id_);
        if (!empty($output)) {
            $this->logmessage("All Cart items fetched ... " . $this->session->getSessionValue('id'));
            return $output;
        } else {
            // $o = $this->session->getSessionValue('id');
            $this->logmessage("No item in Cart !!! " . $this->session->getSessionValue('id'));
            return [];
        }
    }

    
    function get_order_by_user_and_shipping_id($shipping_id)
    {

        $sql_User_Order_id_ = "SELECT 
            o.id AS order_id,
            o.user_id,
            u.name,
            u.email,
            u.phone,
            u.address,
            o.total_amount,
            o.status AS order_status,
            o.created_at AS order_date,

            sm.id AS shipping_id,
            sm.name AS shipping_method,
            sm.description AS shipping_description,
            sm.cost AS shipping_cost,
            sm.estimated_days,

            p.id AS payment_id,
            p.method AS payment_method,
            p.transaction_id,
            p.amount AS payment_amount,
            p.status AS payment_status,
            p.created_at AS payment_date

        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN shipping_methods sm ON o.shipping_id = sm.id
        JOIN payments p ON o.payment_id = p.id
        WHERE o.user_id = $this->user_id_ 
        AND sm.id = $shipping_id;
        ";

        $output = $this->db->query_Executor($sql_User_Order_id_);
        if (!empty($output)) {
            $this->logmessage("All Cart items fetched ... " . $this->session->getSessionValue('id'));
            return $output;
        } else {
            // $o = $this->session->getSessionValue('id');
            $this->logmessage("No item in Cart !!! " . $this->session->getSessionValue('id'));
            return [];
        }
    }


    function get_all_orders_by_user_product_and_order_id()
    {

        $sql_User_Order_id_ = "SELECT 
            o.id              AS order_id,
            o.created_at AS order_date,
            o.status,
            o.total_amount,

            u.id              AS user_id,
            u.name            AS user_name,
            u.email           AS user_email

            

        FROM orders o
        JOIN users u 
            ON o.user_id = u.id


        ORDER BY o.id DESC;

        ";

        $output = $this->db->query_Executor($sql_User_Order_id_);
        if (!empty($output)) {
            $this->logmessage("All Cart items fetched ... " . $this->session->getSessionValue('id'));
            return $output;
        } else {
            // $o = $this->session->getSessionValue('id');
            $this->logmessage("No item in Cart !!! " . $this->session->getSessionValue('id'));
            return [];
        }
    }

    function get_Orders_By_order_id($order_id)
    {

        $sql_User_Order_id_ = "SELECT 
            o.id AS order_id,
            o.status,
            o.created_at AS order_date,
            o.total_amount,

            u.id AS user_id,
            u.name AS user_name,
            u.email,
            u.phone,
            u.address,

            s.name AS shipping_method,

            pmt.method AS payment_method,
            pmt.transaction_id,

            oi.product_id,
            pr.name AS product_name,
            oi.quantity,
            oi.price

        FROM orders o

        JOIN users u ON o.user_id = u.id
        LEFT JOIN shipping_methods s ON o.shipping_id = s.id
        LEFT JOIN payments pmt ON o.payment_id = pmt.id
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products pr ON oi.product_id = pr.id

        WHERE o.id = $order_id;

        ";

        $output = $this->db->query_Executor($sql_User_Order_id_);

        if (!empty($output)) {
            $this->logmessage("All Cart items fetched ... " . $this->session->getSessionValue('id'));
            return $output;
        } else {
            // $o = $this->session->getSessionValue('id');
            $this->logmessage("No item in Cart !!! " . $this->session->getSessionValue('id'));
            return [];
        }
    }

    function delete_Order($id = 0)
    {
        $output = $this->db->remove_Data(['id' => $id], "orders", 2);

        if ($output) {
            $this->logmessage("Order : $id --->  deleted succesfully ...");
            return $output;
        } else {
            $this->logmessage("Error deleting Order : $id --->  !!!");
            return $output;
        }
    }
}
