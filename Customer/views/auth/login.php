<!-- views/auth/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white flex items-center justify-center min-h-screen">

  <div class="w-full max-w-sm bg-gray-900 p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

    <form action="index.php?page=login" method="POST" class="space-y-5">
      <!-- Username -->
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
      <button type="submit" 
        class="w-full bg-white text-black font-semibold py-2 rounded-lg hover:bg-gray-300 transition">
        Login
      </button>
    </form>
            <!-- Error Message -->
        <?php if (!empty($error)): ?>
            <div class=" text-white  rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
    <!-- Optional register link -->
    <p class="mt-6 text-center text-sm">
      Don’t have an account? 
      <a href="index.php?page=register" class="text-gray-400 hover:underline">Register</a>
    </p>
  </div>

</body>
</html>
