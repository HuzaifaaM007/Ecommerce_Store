<?php

use controllers\AdminController\AdminController;
use controllers\AuthController\AuthController;
use controllers\AuthController\AuthController_Customer;
use controllers\CartController\CartController;
use controllers\OrderController\OrderController;
use controllers\OrderController\OrderController_Customer;
use controllers\ProductController\ProductController;
use controllers\ProductController\ProductController_Customer;
use controllers\UsersController\UsersController;
use controllers\UsersController\UsersController_Customer;
use core\Auth\Auth;
use core\controller\Controller;
use models\Order\Order;
// use core\Auth\Auth;
// use core\DataBase\Database;
// use models\Cart\Cart;
// use models\Category\Category;
// use models\Order\Order;
// use models\Product\Product;
// use models\Shipping\Shipping;
// use core\Session\Session;
use models\User\User;



require __DIR__ . "/traits/Logger.php";
require __DIR__ . "/traits/HasherTrait.php";
require __DIR__ . "/traits/Code_Generator_Trait.php";
require_once __DIR__ . "/core/Session.php";
require_once __DIR__ . "/core/Database.php";
require __DIR__ . "/core/Auth.php";
require __DIR__ . "/Customer/controllers/AuthController.php";
require __DIR__ . "/Customer/controllers/CartController.php";
require __DIR__ . "/Customer/controllers/OrderController.php";
require __DIR__ . "/Customer/controllers/ProductController.php";
require __DIR__ . "/Customer/controllers/UsersController.php";
require __DIR__ . "/models/User.php";
require __DIR__ . "/models/Product.php";
require __DIR__ . "/models/Cart.php";
require __DIR__ . "/models/Category.php";
require __DIR__ . "/models/Order.php";
require __DIR__ . "/models/Payment.php";
require __DIR__ . "/models/Shipping.php";
require __DIR__ . "/models/Admin.php";


$page = $_GET['page'] ?? 'products';
$id   = $_GET['id'] ?? null;
$user_id = $_GET['user_id'] ?? null;
$product_name = $_GET['name'] ?? null;
$published = $_GET['published'] ?? null;
$option = $_GET['option'] ?? null;
switch ($page) {
    // case 'test':
    //     $a = new Auth();
    //     $a->create_Security_Codes();
    //     break;
    case 'login':
        $controller = new AuthController_Customer();
        $controller->show_Login_Form(); // loads views/auth/login.php
        break;
    case 'logout':
        $controller = new AuthController_Customer;
        $controller->log_Out(); // loads views/auth/login.php
        break;
    case 'register':
        $controller = new AuthController_Customer();
        $controller->show_Registration_Form();
        break;

    case 'products':
        $controller = new ProductController_Customer();
        $controller->show_All_Products(); // loads views/products/list.php
        break;
    case 'product_details':
        if ($id) {
            $controller = new ProductController_Customer();
            $controller->show_Product_By_Id($id);
        } else {
            $controller = new ProductController_Customer();
            $controller->redirect("index.php?page=products");
        }
        break;
    case 'cart':
        $controller = new CartController();
        $controller->show_Cart_items();
        break;
    case 'add_items_cart':
        $controller = new CartController();
        $controller->add_Cart_items($id);
        break;
    case 'remove_cart_items':
        $controller = new CartController();
        $controller->remove_Cart_items($id);
        break;
    case  'clear_cart':
        $controller = new CartController();
        $controller->clear_Cart();
        break;
    case 'update_cart':
        $controller = new CartController();
        $controller->update_Cart_items();
        break;
    case 'update_cart_without':
        $controller = new CartController();
        $controller->update_quatity($id);
        break;
    case  'clear_cart_without':
        $controller = new CartController();
        $controller->clear_Cart_Without();
        break;
    case  'remove_cart_items_without':
        $controller = new CartController();
        $controller->remove_Cart_items_Without($id);
        break;
    case 'login_Checkout':
        $controller = new AuthController_Customer();
        $controller->logIn_Checkout();
        break;
    case 'login_Checkout':
        $controller = new AuthController_Customer();
        $controller->logIn_Checkout();
        break;
    case 'register_Checkout':
        $controller = new AuthController_Customer();
        $controller->show_Registration_Form_CheckOut();
        break;
    case 'user_settings':
        $controller = new UsersController_Customer();
        $controller->user_Setting();
        break;
    case 'update_profile':
        $controller = new UsersController_Customer();
        $controller->update_Users();
        break;
    case 'reset_password':
        $controller = new AuthController_Customer();
        $controller->reset_Password();
        break;
    case 'update_security_codes':
        $controller = new AuthController_Customer();
        $controller->update_security_codes();
        break;
    case 'login_password_without':
        $controller = new AuthController_Customer();
        $controller->forgot_Password_code_check();
        break;
    case 'delete_account':
        $controller = new UsersController_Customer();
        $controller->delete_User_by_id();
        break;
    case 'user_profile':
        $controller = new UsersController_Customer();
        $controller->get_User_By_Id();
        break;
    case 'check_out_without':
        $controller = new OrderController_Customer();
        $controller->check_Out_Without();
        break;
    case 'check_out':
        $controller = new OrderController_Customer();
        $controller->check_Out();
        break;
    case 'place_order':
        $controller = new OrderController_Customer();
        $controller->place_Order();
        break;
    case 'cancel_account_modal':
        $controller = new UsersController_Customer();
        $controller->cancel_modal();
        break;
    case 'user_orders':
        $controller = new OrderController_Customer();
        $controller->orders_History();
        break;
    // case 'forgot_password':
    //     $controller = new AuthController_Customer();
    //     $controller->forgot_Password();
    //     break;
    default:
        http_response_code(404);
        include __DIR__ . '/views/layouts/header.php';

        echo "
            <div class='flex items-center justify-center min-h-screen'>
                <div class='p-6 text-center text-red-500 text-xl font-semibold'>
                    404 - Page Not Found
                </div>
            </div>
            ";

        include __DIR__ . '/views/layouts/footer.php';
        break;
}
