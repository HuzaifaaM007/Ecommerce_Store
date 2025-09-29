<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">User Profile</h2>

    <div class="bg-white shadow-md rounded-lg p-6">
        <!-- User Info -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="font-medium text-gray-900">
                        <?= htmlspecialchars($user['name']) ?>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium text-gray-900">
                        <?= htmlspecialchars($user['email']) ?>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium text-gray-900">
                        <?= htmlspecialchars($user['phone'] ?? 'N/A') ?>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="font-medium text-gray-900">
                        <?= htmlspecialchars($user['address'] ?? 'N/A') ?>
                    </p>
                </div>
            </div>
        </div>

        
    </div>
</div>
