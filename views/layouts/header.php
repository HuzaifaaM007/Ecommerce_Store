<?php
require_once __DIR__ . "/../../core/Session.php";

$session = core\Session\Session::getInstance();

$url = $_SERVER['REQUEST_URI'];

$session->setSessionValue("url_get", $url);

$pro_id = $session->getSessionValue("product_id");

if (strpos($url, 'page=product_details' ) !== false) {

    $session->setSessionValue("url_get____", $url);

    $url = str_replace('&account_modal=1', '', $url);

    $session->setSessionValue("url_get____2", $url);

} else {
    $session->setSessionValue("url_2get", $url);

    $url = strtok($url, '&');
}

if (strpos($url, '?') === false) {
    $url .= '?';
}


$message = $session->getSessionValue('message');
$session->remove('message');

$session->setSessionValue("url_1", $url);
$error = $session->getSessionValue('error');
$session->remove('error');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My E-Commerce Store</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-white text-black">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0  w-full  bg-black text-white px-6 py-4 shadow">
        <div class="container mx-auto flex justify-between items-center">

            <!-- Left side: Logo + Links -->
            <div class="flex items-center space-x-8">
                <?php if ($session->getSessionValue('isadmin') && $session->has('login')): ?>
                    <a href="index.php?page=admindashboard" class="text-xl font-bold tracking-wide">Dashboard</a>
                <?php else: ?>
                    <a href="index.php?page=products" class="text-xl font-bold tracking-wide">MyStore</a>
                <?php endif; ?>
                <ul class="flex space-x-6 text-sm">
                    <!-- <li><a href="index.php?page=products" class="hover:text-gray-400">Home</a></li> -->
                    <?php if ($session->getSessionValue('isadmin') && $session->has('login')): ?>
                        <li><a href="index.php?page=manage_products" class="hover:text-gray-400">Products</a></li>
                        <li><a href="index.php?page=orders" class="hover:text-gray-400">Orders</a></li>
                    <?php else: ?>
                        <li><a href="index.php?page=products" class="hover:text-gray-400">Products</a></li>
                        <li><a href="index.php?page=cart" class="hover:text-gray-400">Cart</a></li>
                        <?php if ($session->has("login")) : ?>

                            <li><a href="index.php?page=user_orders&user_id=<?= $session->getSessionValue('id') ?>" class="hover:text-gray-400">My Orders</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Right side: Login/Logout -->
            <div class="flex items-center space-x-4">
                <?php if ($session->getSessionValue('login') && $session->getSessionValue('isadmin')): ?>

                    <span class="text-sm">Hi, <?= htmlspecialchars($session->getSessionValue('name')) ?></span>
                    <a href="index.php?page=logout" class="bg-white text-black px-3 py-1 text-sm rounded hover:bg-gray-200">Logout</a>

                <?php elseif ($session->getSessionValue('login')): ?>
                    <span class="text-sm">Hi, <?= htmlspecialchars($session->getSessionValue('name')) ?></span>
                    <form id="account_modal" method="get" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                        <input type="hidden" name="account_modal" value="1">
                    </form>


                    <div class="bg-white text-black h-9 w-9 rounded-full overflow-hidden flex items-center justify-center hover:border-2">

                        <!-- 
                        <button type="submit" form="account_modal" class="block w-full h-full">

                         

                        </button> -->
                        <a href="<?= htmlspecialchars($url) ?>&account_modal=1" class="block w-full h-full">
                            <?php if (!empty($session->getSessionValue("image"))): ?>
                                <img src="././../public/<?= htmlspecialchars($session->getSessionValue("image")) ?>"
                                    alt="<?= htmlspecialchars($session->getSessionValue('name')) ?>"
                                    class="w-full h-full object-cover rounded-full">
                            <?php else: ?>
                                <img src="./public/default_Images/default_User.png"
                                    alt="<?= htmlspecialchars($session->getSessionValue('name')) ?>"
                                    class="w-full h-full object-cover rounded-full"> <?php endif; ?>

                        </a>
                    </div>

                    <!-- <a href="index.php?page=logout" class="bg-white text-black px-3 py-1 text-sm rounded hover:bg-gray-200">Logout</a> -->

                <?php else: ?>

                    <!-- <a href="index.php?page=login" class="bg-white text-black px-3 py-1 text-sm rounded hover:bg-gray-200">Login</a> -->

                    <div class="bg-white text-black h-9 w-9 rounded-full overflow-hidden flex items-center justify-center hover:border-2">

                        <!-- 
                        <button type="submit" form="account_modal" class="block w-full h-full">

                         

                        </button> -->
                        <a href="<?= htmlspecialchars($url) ?>&account_modal=1" class="block w-full h-full">
                            <img src="./public/default_Images/default_User.png"
                                alt="<?= htmlspecialchars($session->getSessionValue('name')) ?>"
                                class="w-full h-full object-cover rounded-full">

                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php include __DIR__ . "/../../Customer/views/auth/account_Modal.php"; ?>

    <?php include __DIR__ . "/../../Customer/views/auth/loginModal.php"; ?>

    <?php include __DIR__ . "/../../Customer/views/auth/register_Modal.php"; ?>

    <?php include __DIR__ . "/../../Customer/views/auth/Forgot_Password_Modal.php"; ?>

    <main class="container mx-auto px-6 py-20">