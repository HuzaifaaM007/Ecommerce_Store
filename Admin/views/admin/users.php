<!-- views/admin/users.php -->

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Manage Users</h2>
    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Success Message -->
    <?php if (!empty($success)): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <!-- Add user Button -->
    <!-- <div class="mb-4">
        <a href="index.php?page=add_users"
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            + Add 
        </a>
    </div> -->

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="text-lg font-semibold">Users List</h3>
        </div>

        <?php if (!empty($users)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Address</th>
                            <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th> -->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-800"><?= $user['id'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-800"><?= $user['name'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-800"><?= $user['phone'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-800">$<?= $user['address'] ?></td>
                                <!-- <td class="px-6 py-4 text-sm text-gray-800"><?= $user['stock'] ?></td> -->
                                <!-- <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                                        <?php if ($user['stock'] > 0) echo 'bg-green-100 text-green-700';
                                        else echo 'bg-red-100 text-red-700'; ?>">
                                        <?= $user['stock'] > 0 ? 'Available' : 'Out of Stock' ?>
                                    </span>
                                </td> -->
                                <td class="px-6 py-4 text-sm flex gap-2">
                                    <a href="index.php?page=user_details&user_id=<?= $user['id'] ?>"
                                        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">View</a>
                                    <!-- <a href="index.php?page=edit_user&id=<?= $user['id'] ?>"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Edit</a> -->
                                    <!-- <a href="index.php?page=unpublish_user&id=<?= $user['id'] ?>"
                                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Unpublish</a> -->
                                    <a href="index.php?page=delete_user&id=<?= $user['id'] ?>"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="p-4 text-gray-600">No users found.</p>
        <?php endif; ?>
    </div>
</div>