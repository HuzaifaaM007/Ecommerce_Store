<?php

namespace controllers\AdminController;

use core\controller\Controller;
use core\Session\Session;
use models\Admin\Admin;
use models\Category\Category;
use models\Order\Order;
use models\Product\Product;
use models\User\User;

// require __DIR__ . "/../../core/Controller.php";

class AdminController extends Controller
{

    private $Admin;
    private $Product;
    private $user;
    private $order;
    private $session;

    function __construct()
    {
        $this->session = Session::getInstance();
        $this->Admin = new Admin();
        $this->Product = new Product();
        $this->user = new User();
        $this->order = new Order();
    }


    function Show_Dashboard()
    {
        if ($this->session->has("login") && $this->session->has("isadmin")) {
            $stats = [];
            $orders = $this->order->get_All_Orders();
            $sales = 100;
            foreach ($orders as $order) {
                if ($order['status'] == "delivered") {
                    $sales += $order['total_amount'];
                }
            }
            $stats['products'] = count($this->Product->get_All_Products());
            $stats['orders'] = count($this->order->get_All_Orders());
            $stats['users'] = count($this->user->get_All_Users()) ?? 0;
            $stats['sales'] = $sales;
            $order_output = $this->order->get_all_orders_by_user_product_and_order_id();

            $this->view_Admin("admin/dashboard", ["stats" => $stats, "recentOrders" => $order_output]);
        }
        else {
            $this->redirect("index.php?page=admin_Login");
        }
    }
}
