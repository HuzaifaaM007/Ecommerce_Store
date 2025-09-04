<?php

namespace controllers\UsersController;

use controllers\OrderController\OrderController_Admin;
use core\controller\Controller;
use core\Session\Session;
use models\Order\Order;
use models\User\User;

class UsersController extends Controller
{

    private $user;
    private $session;
    private $order;

    function __construct()
    {
        $this->user = new User();
        $this->session = Session::getInstance();
        $this->order = new Order();
    }

    function get_Users()
    {

        if ($this->session->has("login") && $this->session->has("isadmin")) {

            $output = $this->user->get_All_Users();
            $this->view_Admin("admin/users", ["users" => $output]);
        } else {
            $this->redirect("index.php?page=admin_Login");
        }
    }

    function get_User_By_Id($user_id)
    {
        $output = $this->user->get_User_By_Id($user_id);

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


        $this->view_Admin("users/user_details", ["user" => $output[0], "orders" => $Orders_Output,"orderitems" => $order_items_data]);
    }

    function delete_User_by_id($user_id)
    {
        $this->user->delete_User($user_id);

        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $this->redirect($referer);
    }
}
