<?php
// If cancel is clicked, don't show modal
if (isset($_POST['cancel_login'])) {
    $session->setSessionValue("show_Login", false);
}

// Show login if explicitly requested OR session says so
$showLogin = (isset($_POST['login']) && $_POST['login'] == "1") || $session->getSessionValue("show_Login");

$session->remove("show_Login");

$error = $session->getSessionValue("error");
$session->remove("error");
?>

<?php if ($showLogin): ?>
    <div class="fixed inset-0 text-white bg-black bg-opacity-70 flex items-center justify-center">
        <div class="w-full max-w-sm bg-gray-900 p-8 rounded-2xl shadow-lg relative">
            <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

            <form action="index.php?page=login_Checkout" method="POST" class="space-y-5">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="text" id="email" name="email"
                        class="w-full px-4 py-2 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="Enter your email" required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="Enter your password" required>
                </div>

                <!-- Submit -->
                <button type="submit" name="login"
                    class="w-full bg-white text-black font-semibold py-2 rounded-lg hover:bg-gray-300 transition">
                    Login
                </button>
            </form>
            <form method="post">
                <input type="hidden" name="cancel_login" value="1">
                <p class="mt-6 text-center text-sm">
                    Don’t want to continue ?
                    <button type="submit" class="text-gray-400 hover:underline">
                        Cancel
                    </button>
                </p>
            </form>

            <!-- Error -->
            <?php if (!empty($error)): ?>
                <div class="mt-4 text-center text-gray-400"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
          
        </div>
    </div>
<?php endif; ?>