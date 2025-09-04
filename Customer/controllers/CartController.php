<?php

namespace controllers\CartController;

use core\controller\Controller;
use core\Session\Session;
use models\Cart\Cart;

class CartController extends Controller
{

    private $cart;
    private $session;


    function __construct()
    {
        $this->cart = new Cart();
        $this->session = Session::getInstance();
    }

    function show_Cart_items()
    {
        if ($this->session->has('id')) {
            $output = $this->cart->get_Cart_items();

            $this->view_Customer("cart/cart", ["cartItems" => $output]);
        } else {
            $output = $this->cart->get_Cart_items_wt_LogIn();

            $quantity = $this->session->getSessionValue("quatity_of_products");

            $this->view_Customer("cart/cart", ["cartItems" => $output, "products_Quantity" => $quantity]);
        }
    }

    function add_Cart_items($product_Id, $user_id, $quantity = 1)
    {
        if ($this->session->has('id')) {
            $this->cart->add_To_Cart(["user_id" => $user_id, "product_id" => $product_Id, "quantity" => $quantity]);

            $this->redirect("index.php?page=cart");
            // $this->show_Cart_items();


        } else {
            $this->session->setSessionArrayValue("Cart_Items", $product_Id);

            $P_quantity = $this->session->getSessionValue("quatity_of_products");

            $product_Quantity = $P_quantity[$product_Id];
            
            $quantity = $product_Quantity + 1;

            $this->session->setSessionArrayValue("quatity_of_products", [$product_Id => $quantity]);
            $this->redirect("index.php?page=cart");
        }
    }

    function add_Cart_items_Without($product_Id, $user_id, $quantity = 1)
    {


        $this->cart->add_To_Cart(["user_id" => $user_id, "product_id" => $product_Id, "quantity" => $quantity]);
        // echo " quantity => $quantity ";


    }

    function update_quatity()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $product_Id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $this->session->setSessionArrayValue("quatity_of_products", [$product_Id => $quantity]);

            // $this->show_Cart_items();
            $this->redirect("index.php?page=cart");
        }
    }

    function clear_Cart_Without()
    {
        $this->session->remove("Cart_Items");
        $this->session->remove("quatity_of_products");
        // $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        // $this->redirect($referer);

        // $this->show_Cart_items();
        $this->redirect("index.php?page=cart");
    }

    function remove_Cart_items_Without($product_Id)
    {
        $this->session->remove_Session_Array_Value("Cart_Items", $product_Id);

        // $this->show_Cart_items();
        $this->redirect("index.php?page=cart");
        //  $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        // $this->redirect($referer);

    }
    function remove_Cart_items($product_Id)
    {
        $this->cart->remove_From_Cart($product_Id);
        // $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        // $this->redirect($referer);
        // $this->show_Cart_items();
        $this->redirect("index.php?page=cart");
    }

    function update_Cart_items()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $product_Id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $this->cart->update_Quantity(['quantity' => $quantity], ['product_id' => $product_Id]);
            // $this->show_Cart_items();
            $this->redirect("index.php?page=cart");
        }
    }

    function clear_Cart()
    {
        $this->cart->clear_Cart();
        $this->show_Cart_items();
    }
}
