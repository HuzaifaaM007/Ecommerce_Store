<?php
// If cancel is clicked, don't show modal
if (isset($_GET['cancel_register'])) {
    $session->setSessionValue("show_Register", false);
}

// Show login if explicitly requested OR session says so
$showRegister = (isset($_GET['show_Register']) && $_GET['show_Register'] == "1") || $session->getSessionValue("show_Register");

$session->remove("show_Register");

$error = $session->getSessionValue("error");

$session->remove("error");
?>
<?php if ($showRegister): ?>
    <div class="fixed inset-0 text-white bg-black bg-opacity-70 flex items-center justify-center">
        <div class="w-full max-w-sm bg-gray-900 p-8 rounded-2xl shadow-lg relative">
            <h2 class="text-2xl font-bold text-center mb-6">Register</h2>
           
            <a href="<?= htmlspecialchars($url) ?>&cancel_register=1" class="absolute top-2 right-6 text-gray-400 hover:text-white text-sm">✕</a>

            <form action="index.php?page=register_Checkout" method="POST" class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium">Full Name</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-1 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="Enter your name" required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-1 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="Enter your email" required>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium">Phone No</label>
                    <input type="text" id="phone" name="phone" required
                        class="w-full px-4 py-1 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="Enter your phone no" required>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium">Address</label>
                    <input type="text" id="address" name="address" required
                        class="w-full px-4 py-1 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="Enter your address" required>
                </div>
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-1 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="Enter your password" required
                        pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{9,}$"
                        title="Password must be at least 9 characters long and include a letter, number, and special character.">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                        class="w-full px-4 py-1 mt-1 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-white"
                        placeholder="confirm your password" required>
                </div>

                <!-- Submit -->
                <button type="submit" name="login"
                    class="w-full bg-white text-black font-semibold py-2 rounded-lg hover:bg-gray-300 transition">
                    Register
                </button>
            </form>


            <!-- Error -->
            <?php if (!empty($error)): ?>
                <div class="mt-4 text-center text-red-400"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?>