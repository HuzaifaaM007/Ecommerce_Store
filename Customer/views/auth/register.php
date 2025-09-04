<!-- views/auth/register.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white flex items-center justify-center min-h-screen">

    <!-- <div class="flex-grow flex items-center justify-center"> -->
    <div class="max-w-md w-full  bg-gray-900 p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Create Account</h2>

        <!-- Registration Form -->
        <form action="index.php?page=register" method="POST" class="space-y-4">
            <!-- Full Name -->
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
            <button type="submit"
                class="w-full bg-white text-black font-semibold py-2 rounded-lg hover:bg-gray-300 transition">
                Register
            </button>
        </form>
        <?php if (!empty($error)): ?>
            <div class="text-sm text-center rounded mt-2">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Login Redirect -->
        <p class="mt-2 text-center text-sm">
            Already have an account?
            <a href="index.php?page=login" class="text-gray-400 hover:underline router-link">Login</a>
        </p>
    </div>
    <!-- </div> -->

</body>

</html>