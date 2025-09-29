<div class="container mx-auto p-6">
    <?php if (!empty($message)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <strong class="font-bold"><?= $message ?></strong>
            <!-- <span class="block sm:inline"> Thank you for your purchase.</span> -->
        </div>
    <?php elseif (!empty($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong class="font-bold"><?= $error ?></strong>
            <!-- <span class="block sm:inline"> Thank you for your purchase.</span> -->
        </div>
    <?php endif; ?>
    <h2 class="text-2xl font-bold mb-6">Account Settings</h2>

    <div class="bg-white shadow-md rounded-lg p-6 space-y-6">

        <!-- Edit Profile -->
        <div>

            <h3 class="text-lg font-semibold mb-4">Edit Profile</h3>
            <form action="index.php?page=update_profile" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Address</label>
                    <textarea name="address" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Profile</button>
            </form>
        </div>
        <!-- Security Codes for reseting passwords -->
        <div>
            <h3 class="text-lg font-semibold mb-4">Security Codes</h3>
            <?php if (!empty($codes)): ?>

                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($codes as $code) : ?>
                            <div>
                                <p class="font-medium text-gray-900">
                                    <?= htmlspecialchars($code["security_code"]) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Codes</button> -->
                <a href="index.php?page=update_security_codes" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Codes</a>
            <?php else: ?>

                <a href="index.php?page=update_security_codes" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Generate Security Codes</a>

            <?php endif; ?>
        </div>

        <!-- Reset Password -->
        <div>

            <h3 class="text-lg font-semibold mb-4">Reset Password</h3>
            <form action="index.php?page=reset_password" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Current Password</label>
                    <input type="password" name="current_password" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">New Password</label>
                    <input type="password" name="new_password" class="w-full px-4 py-2 border rounded-lg" required
                        placeholder="Enter your new password"
                        pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{9,}$"
                        title="Password must be at least 9 characters long and include a letter, number, and special character.">

                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Change Password</button>
            </form>
        </div>

        <!-- Delete Account -->
        <div>
            <h3 class="text-lg font-semibold mb-4 text-red-600">Delete Account</h3>
            <form action="index.php?page=delete_account" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete Account</button>
            </form>
        </div>

    </div>
</div>