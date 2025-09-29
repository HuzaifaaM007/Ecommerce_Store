<?php
// If cancel is clicked, don't show modal
if (isset($_GET['cancel_account_modal'])) {
    $session->setSessionValue("show_account_modal", false);
}

// Show modal if requested or from session
$showAccount_Modal = (isset($_GET['account_modal']) && $_GET['account_modal'] == "1")
    || $session->getSessionValue("show_account_modal");

$session->remove("show_account_modal");

// // Error handling
// $error = $session->getSessionValue("error");
// $session->remove("error");


// $url = $_SERVER['REQUEST_URI'];
    // $session->setSessionValue("url_get", $url);


// if (strpos($url, 'page=product_details') !== false) {

//     $url = strtok($url, "&");
//     $url = $url . "&$pro_id";

//     $session->setSessionValue("url", $url);

// } else {

//     $url = strtok($url, '&');
// }


// if (strpos($url, '?') === false) {
//     $url .= '?';
// }


?>

<?php if ($showAccount_Modal): ?>
    <div class="fixed right-6 top-16 text-white">
        <div class="w-full max-w-md bg-gray-800 p-6 rounded-xl shadow-lg shadow-gray-800 relative">

            <!-- Cancel Button
            <form method="post" class="absolute top-4 right-4">
                <input type="hidden" name="cancel_login" value="1">
                <button type="submit" class="text-gray-400 hover:text-white text-sm">✕</button>
            </form> -->
            <a href="<?= htmlspecialchars($url) ?>&cancel_account_modal=1" class="absolute top-4 right-4 text-gray-400 hover:text-white text-sm">✕</a>

            <?php if ($session->getSessionValue('login')): ?>
                <div class="flex items-center gap-3 mb-4 pr-8">
                    <div class="bg-white text-black h-7 w-7 rounded-full overflow-hidden hover:border-2">
                        <?php if (!empty($session->getSessionValue("image"))): ?>
                            <img src="././../public/<?= htmlspecialchars($session->getSessionValue("image")) ?>"
                                alt="<?= htmlspecialchars($session->getSessionValue('name')) ?>"
                                class="w-full h-full object-cover rounded-full">
                        <?php else: ?>
                            <img src="./public/default_Images/default_User.png"
                                alt="<?= htmlspecialchars($session->getSessionValue('name')) ?>"
                                class="w-full h-full object-cover rounded-full">
                        <?php endif; ?>
                    </div>
                    <div class="text-sm">
                        <span class="font-bold"><?= htmlspecialchars($session->getSessionValue('name')) ?></span>
                    </div>
                </div>

                <!-- User Actions -->
                <div class="flex flex-col  gap-2 mb-4">
                    <a href="index.php?page=user_profile" class="text-white text-sm px-6 py-2 hover:underline">My Profile</a>
                    <a href="index.php?page=user_settings" class="text-white tetx-sm px-6 py-2 hover:underline">Settings</a>
                </div>

                <!-- Logout -->
                <a href="index.php?page=logout" class="block bg-white text-black py-1 px-3 rounded hover:bg-gray-200 text-center">
                    Logout
                </a>

            <?php else: ?>
                <!-- Not logged in -->
                <div class="pl-2 pr-7 text-sm text-gray-300 mb-4">You are not logged in.</div>

                <div class="flex flex-col gap-2 mb-4">

                    <a href="<?= htmlspecialchars($url) ?>&cancel_account_modal=1&login=1" class="block bg-white text-black py-1 px-3 rounded hover:bg-gray-200 text-center">
                        Login
                    </a>
                    <a href="<?= htmlspecialchars($url) ?>&cancel_account_modal=1&show_Register=1" class="block bg-white text-black py-1 px-3 rounded hover:bg-gray-200 text-center">
                        Register
                    </a>
                </div>
            <?php endif; ?>

            <!-- Error Display -->
            <?php if (!empty($error)): ?>
                <div class="mt-4 text-center text-red-400 text-sm">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?>