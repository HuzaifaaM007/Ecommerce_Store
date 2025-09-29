

<?php

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


use core\Auth\Auth;

$i = new Auth();

$i->forgot_Password("379779","Customer@Ecommerce.com");

