<?php

namespace controllers\OrderController;

use core\controller\Controller;
use core\Session\Session;
use models\Order\Order;

class OrderController_Admin extends Controller
{
    private $order;
    private $session;
    function __construct()
    {
        $this->order = new Order();
        $this->session = Session::getInstance();
    }

    function show_All_Orders()
    {
        if ($this->session->has("login") && $this->session->has("isadmin")) {

            $order_Output = $this->order->get_all_orders_by_user_product_and_order_id();
            $order_Items_Ouput = [];
            foreach ($order_Output as $orders) {
                $order_Items_Ouput[$orders['order_id']] = $this->order->get_Order_Item_by_OrderId($orders['order_id']);
            }

            $this->view_Admin("orders/orders", ["orders" => $order_Output, "order_items" => $order_Items_Ouput]);
        } else {
            $this->redirect("index.php?page=admin_Login");
        }
    }



    function orders_History($user_id)
    {
        if ($this->session->has('login')) {

            $Orders_Output = $this->order->get_user_orders($user_id);



            if (!empty($Orders_Output)) {
                $order_items_data = [];
                foreach ($Orders_Output as $orders) {


                    $order_items_data[$orders['order_id']] = $this->order->get_Order_Item_by_OrderId($orders['order_id']);
                }

                // print_r($order_items_data);

            } else {
                $order_items_data = [];
            }



            $this->view_Admin("users/orders", ["orders" => $Orders_Output, "orderitems" => $order_items_data]);
        } else {
            $this->view_Admin("auth/admin_Login");
        }
    }

    function get_order_By_order_id($order_id)
    {


        if ($this->session->has("login") && $this->session->has("isadmin")) {
            $output = $this->order->get_Orders_By_order_id($order_id);

            $order_Items_Ouput[$order_id] = $this->order->get_Order_Item_by_OrderId($order_id);



            // print_r($output);
            // print_r($order_Items_Ouput);
            $this->view_Admin("orders/order_details", ["order" => $output[0] ?? [], "order_items" => $order_Items_Ouput]);
        } else {
            $this->redirect("index.php?page=admin_Login");
        }
    }

    function delete_Order_by_id($order_id)
    {
        $output = $this->order->delete_Order($order_id);

        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $this->redirect($referer);
    }

    function update_Order($order_id, $option)
    {
        if ($option == 1) {
            $this->order->update_Order_Status(["status" => "pending"], ['id' => $order_id]);
        } else if ($option == 2) {
            $this->order->update_Order_Status(["status" => "processing"], ['id' => $order_id]);
        } else if ($option == 3) {
            $this->order->update_Order_Status(["status" => "shipped"], ['id' => $order_id]);
        } else if ($option == 4) {
            $this->order->update_Order_Status(["status" => "delivered"], ['id' => $order_id]);
        } else if ($option == 5) {
            $this->order->update_Order_Status(["status" => "cancelled"], ['id' => $order_id]);
        }


        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $this->redirect($referer);
    }
}
