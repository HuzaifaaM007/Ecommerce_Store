<?php

use controllers\AdminController\AdminController;
use controllers\AuthController\AuthController_Admin;
use controllers\OrderController\OrderController_Admin;
use controllers\ProductController\ProductController_Admin;
use controllers\UsersController\UsersController;
// use core\Auth\Auth;
// use core\DataBase\Database;
// use models\Cart\Cart;
// use models\Category\Category;
// use models\Order\Order;
// use models\Product\Product;
// use models\Shipping\Shipping;
// use core\Session\Session;
use models\User\User;



require __DIR__ . "/../traits/Logger.php";
require __DIR__ . "/../traits/HasherTrait.php";
require __DIR__ . "/../traits/Code_Generator_Trait.php";

require_once __DIR__ . "/../core/Session.php";
require_once __DIR__ . "/../core/Database.php";
require __DIR__ . "/../core/Auth.php";
// require __DIR__ . "/core/Controller.php";

require __DIR__ . "/controllers/AuthController.php";
require __DIR__ . "/controllers/AdminController.php";
require __DIR__ . "/controllers/OrderController.php";
require __DIR__ . "/controllers/PaymentController.php";
require __DIR__ . "/controllers/ProductController.php";
require __DIR__ . "/controllers/ShippingController.php";
require __DIR__ . "/controllers/UsersController.php";
require __DIR__ . "/../models/User.php";
require __DIR__ . "/../models/Product.php";
require __DIR__ . "/../models/Cart.php";
require __DIR__ . "/../models/Category.php";
require __DIR__ . "/../models/Order.php";
require __DIR__ . "/../models/Payment.php";
require __DIR__ . "/../models/Shipping.php";
require __DIR__ . "/../models/Admin.php";


$page = $_GET['page'] ?? 'admin_Login';
$id   = $_GET['id'] ?? null;
$user_id = $_GET['user_id'] ?? null;
$product_name = $_GET['name'] ?? null;
$published = $_GET['published'] ?? null;
$option = $_GET['option']??null;
switch ($page) {
    case 'admin_Login':
        $controller = new AuthController_Admin();
        $controller->show_Admin_Login_Form();
        break;
    case 'logout':
        $controller = new AuthController_Admin();
        $controller->log_Out(); // loads views/auth/login.php
        break;
    case 'products':
        $controller = new ProductController_Admin();
        $controller->show_All_Products(); // loads views/products/list.php
        break;
    case 'product_details':
        if ($id) {
            $controller = new ProductController_Admin();
            $controller->show_Product_By_Id($id);
        } else {
            $controller->redirect("products/list");
        }
        break;
    case 'user_details':
        $controller = new UsersController();
        $controller->get_User_By_Id($user_id);
        break;
    case 'admindashboard':
        $controller = new AdminController();
        $controller->Show_Dashboard();
        break;
    case 'orders':
        $controller = new OrderController_Admin();
        $controller->show_All_Orders();
        break;
    case 'manage_products':
        $controller = new ProductController_Admin();
        $controller->show_products_Admin();
        break;
    case 'add_products':
        $controller = new ProductController_Admin();
        $controller->create_New_Product();
        break;
    case 'delete_product':
        $controller = new ProductController_Admin();
        $controller->delete_product($id, $product_name);
        break;
    case 'edit_product':
        $controller = new ProductController_Admin();
        $controller->edit_product($id, $product_name);
        break;
    case 'publish_product':
        $controller = new ProductController_Admin();
        $controller->publish_product($id, $product_name, $published);
        break;
    case 'unpublish_product':
        $controller = new ProductController_Admin();
        $controller->publish_product($id, $product_name, $published);
        break;
    case 'users':
        $controller = new UsersController();
        $controller->get_Users();
        break;
    case 'delete_user':
        $controller = new UsersController();
        $controller->delete_User_by_id($id);
        break;
    case 'user_orders':
        $controller = new OrderController_Admin();
        $controller->orders_History($user_id);
        break;
    case 'order_details':
        $controller = new OrderController_Admin();
        $controller->get_order_By_order_id($id);
        break;
    case 'delete_order':
        $controller = new OrderController_Admin();
        $controller->delete_Order_by_id($id);
        break;
    case 'update_order':
        $controller = new OrderController_Admin();
        $controller->update_Order($id,$option);
        break;
    default:
        http_response_code(404);
        include __DIR__ . '/../views/layouts/header.php';

        echo "
            <div class='flex items-center justify-center min-h-screen'>
                <div class='p-6 text-center text-red-500 text-xl font-semibold'>
                    404 - Page Not Found
                </div>
            </div>
            ";

        include __DIR__ . '/../views/layouts/footer.php';
        break;
}
