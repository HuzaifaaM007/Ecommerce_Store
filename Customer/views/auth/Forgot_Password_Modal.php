<?php
// If cancel is clicked, don't show modal
if (isset($_GET['cancel_Forgot_Password'])) {
    $session->setSessionValue("show_Forgot_Password", false);
}

// Show login if explicitly requested OR session says so
$showLogin = (isset($_GET['show_Forgot_Password']) && $_GET['show_Forgot_Password'] == "1") || $session->getSessionValue("show_Forgot_Password");

$session->remove("show_Forgot_Password");

$error = $session->getSessionValue("error");
$session->remove("error");
?>

<?php if ($showLogin): ?>
    <div class="fixed inset-0 text-white bg-black bg-opacity-70 flex items-center justify-center">
        <div class="w-full max-w-sm bg-gray-900 p-8 rounded-2xl shadow-lg relative">
            <h2 class="text-2xl font-bold text-center mb-6">Forgot Password</h2>
            <a href="<?= htmlspecialchars($url) ?>&cancel_login=1" class="absolute top-4 right-4 text-gray-400 hover:text-white text-sm">✕</a>

            <form action="index.php?page=login_password_without" method="POST" class="space-y-5">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="text" id="email" name="email"
                        class="w-full px-4 py-2 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="Enter your email" required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium">Security Code</label>
                    <input type="text" id="code" name="code"
                        class="w-full px-4 py-2 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="Enter your the security code" required>
                    <!-- <p class="text-xs text-right">

                        <a href="<?= htmlspecialchars($url) ?>&cancel_login=1&show_Forgot_Password=1" class="text-gray-400 hover:underline">
                            Forgot Password
                        </a>
                    </p> -->
                </div>


                <!-- Submit -->
                <button type="submit" name="login"
                    class="w-full bg-white text-black font-semibold py-2 rounded-lg hover:bg-gray-300 transition">
                    Login
                </button>
            </form>

            <!-- <form method="post">
                <input type="hidden" name="cancel_login" value="1"> -->
            <!-- <p class="mt-6 text-center text-sm">
                Don’t have Account?
                <a href="<?= htmlspecialchars($url) ?>&cancel_login=1&show_Register=1" class="text-gray-400 hover:underline">
                    Register
                </a>
            </p>
            </form> -->

            <!-- Error -->
            <?php if (!empty($error)): ?>
                <div class="mt-4 text-center text-gray-400"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?>