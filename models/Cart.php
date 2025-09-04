<?php

namespace models\Cart;

use core\DataBase\Database;
use core\Session\Session;
use traits\Logger\Logger;

class Cart
{
    use Logger;

    private $session;
    private $db;

    private $user_id;



    function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
        $this->user_id = $this->session->getSessionValue('id');
    }

    function add_To_Cart(array $product_Data = []): bool
    {
        $product_Output = $this->db->getData(["stock"], "products", ["id" => $product_Data["product_id"]], 2);

        $output = $this->db->getData([], "cart", ["user_id" => $product_Data["user_id"], "product_id" => $product_Data["product_id"]], 3);
        // print_r($output);
        // $quantity = $output[0]["quantity"] + 1;


        if (!empty($output)) {
            $quantity = $output[0]["quantity"] + $product_Data["quantity"];

            if ($product_Output[0]["stock"] < $quantity) {
                $quantity = $product_Output[0]["stock"];
            }

            $success = $this->db->update_Data("cart", ["quantity" => $quantity], ["product_id" => $output[0]["product_id"]]);
            $this->logmessage("product added to Cart : " . $product_Data['product_id'] . " Quantity = " . $quantity . "....");
            return $success;
        } else {

            $this->db->insert_Data($product_Data, "cart", [], 1);
            $this->logmessage("Adding Product to cart : " . $product_Data['product_id']);
            return false;
        }
    }

    function remove_From_Cart(int $product_Id): bool
    {
        $output = $this->db->remove_Data(["product_id" => $product_Id], "cart", 2);
        if ($output) {
            $this->logmessage("Product removed from cart : " . $product_Id);
            return $output;
        } else {
            $this->logmessage("Error removing Product from cart : " . $product_Id);
            return $output;
        }
    }

    function update_Quantity(array $product_Data, array $conditions): bool
    {
        $conditions['user_id'] = $this->session->getSessionValue('id');
        $output = $this->db->update_Data("cart", $product_Data, $conditions);
        if ($output) {
            $this->logmessage("Product qantity updated: " . $product_Data['product_id']);
            return $output;
        } else {
            $this->logmessage("Error updating Product quantity : " . $product_Data['product_id']);
            return $output;
        }
    }

    function get_Cart_items(): array
    {
        $sqlCartItems = "SELECT 
            c.id AS cart_id,
            c.user_id,
            p.id AS product_id,
            p.name AS product_name,
            p.image AS image_URL,
            p.stock AS stock,
            p.price AS product_price,
            c.quantity AS quantity,
            (p.price * c.quantity) AS subtotal
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = $this->user_id;
        ";



        $output = $this->db->query_Executor($sqlCartItems);
        if (!empty($output)) {
            $this->logmessage("All Cart items fetched for user_id: " . $this->user_id . "...");
            return $output;
        } else {
            // $o = $this->session->getSessionValue('id');
            $this->logmessage("No item in Cart !!! " . $this->user_id);
            return [];
        }
    }

    function get_Cart_items_wt_LogIn(): array
    {
        $output = [];
        $cart_Items = $this->session->getSessionValue("Cart_Items") ?? [];
        foreach ($cart_Items as $product_Id) {
            $sqlCartItems = "SELECT 
            -- c.id AS cart_id,
            -- c.user_id,
            p.id AS product_id,
            p.name AS product_name,
            p.image AS image_URL,
            p.stock AS stock,
            p.price AS product_price,
            p.price AS subtotal
        
        FROM products p WHERE p.id = $product_Id;
        ";

            $outputCart = $this->db->query_Executor($sqlCartItems);

            $output[$product_Id] = $outputCart;
        }


        if (!empty($output)) {
            $this->logmessage("All Cart items fetched for session value without login ...");
            return $output;
        } else {
            // $o = $this->session->getSessionValue('id');
            $this->logmessage("No item in Cart without login !!! ");
            return [];
        }
    }

    function clear_Cart(): bool
    {

        $output = $this->db->remove_Data(["id" => $this->session->getSessionValue('id')], "cart", 1);
        if ($output) {
            $this->logmessage("Cart cleared for: " . $this->session->getSessionValue('id'));
            return $output;
        } else {
            $this->logmessage("Error clearing cart for: " . $this->session->getSessionValue('id'));
            return $output;
        }
    }
}
