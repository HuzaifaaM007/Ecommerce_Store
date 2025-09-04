<?php



use controllers\AdminController\AdminController;
use controllers\AuthController\AuthController;
use controllers\CartController\CartController;
use controllers\OrderController\OrderController;
use controllers\ProductController\ProductController;
use controllers\UsersController\UsersController;
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
require_once __DIR__ . "/core/Session.php";
require_once __DIR__ . "/core/Database.php";
require __DIR__ . "/core/Auth.php";
require __DIR__ . "/controllers/AuthController.php";
require __DIR__ . "/controllers/ProductController.php";
require __DIR__ . "/controllers/CartController.php";
require __DIR__ . "/controllers/AdminController.php";
require __DIR__ . "/controllers/OrderController.php";
require __DIR__ . "/controllers/UsersController.php";
require __DIR__ . "/models/User.php";
require __DIR__ . "/models/Product.php";
require __DIR__ . "/models/Cart.php";
require __DIR__ . "/models/Category.php";
require __DIR__ . "/models/Order.php";
require __DIR__ . "/models/Payment.php";
require __DIR__ . "/models/Shipping.php";
require __DIR__ . "/models/Admin.php";


$t = new Order();

$o = $t->get_user_orders("1");

print_r($o);
