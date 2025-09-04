<?php
require_once __DIR__ . "/../../core/Session.php";

$session = core\Session\Session::getInstance();

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
    <nav class="bg-black text-white px-6 py-4 shadow">
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
                    <a href="index.php?page=logout" class="bg-white text-black px-3 py-1 text-sm rounded hover:bg-gray-200">Logout</a>
                <?php else: ?>

                    <a href="index.php?page=login" class="bg-white text-black px-3 py-1 text-sm rounded hover:bg-gray-200">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-8">