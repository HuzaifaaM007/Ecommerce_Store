<!-- views/admin/dashboard.php -->

<div class="p-6">
    <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Users Card -->
        <div class="bg-blue-600 text-white rounded-2xl shadow p-5 flex flex-col justify-between">
            <div>
                <h5 class="text-lg font-semibold">Users</h5>
                <p class="text-3xl font-bold mt-2"><?= $stats['users'] ?? 0 ?></p>
            </div>
            <div class="text-center mt-4">
                <a href="index.php?page=users" class="text-sm underline">Manage Users</a>
            </div>
        </div>

        <!-- Products Card -->
        <div class="bg-green-600 text-white rounded-2xl shadow p-5 flex flex-col justify-between">
            <div>
                <h5 class="text-lg font-semibold">Products</h5>
                <p class="text-3xl font-bold mt-2"><?= $stats['products'] ?? 0 ?></p>
            </div>
            <div class="text-center mt-4">
                <a href="index.php?page=manage_products" class="text-sm underline">Manage Products</a>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="bg-yellow-500 text-white rounded-2xl shadow p-5 flex flex-col justify-between">
            <div>
                <h5 class="text-lg font-semibold">Orders</h5>
                <p class="text-3xl font-bold mt-2"><?= $stats['orders'] ?? 0 ?></p>
            </div>
            <div class="text-center mt-4">
                <a href="index.php?page=orders" class="text-sm underline">View Orders</a>
            </div>
        </div>

        <!-- Sales Card -->
        <div class="bg-red-600 text-white rounded-2xl shadow p-5 flex flex-col justify-between">
            <div>
                <h5 class="text-lg font-semibold">Sales</h5>
                <p class="text-3xl font-bold mt-2">$<?= $stats['sales'] ?? 0 ?></p>
            </div>
            <div class="text-center mt-4">
                <!-- <a href="index.php?page=reports" class="text-sm underline">View Report</a> -->
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-2xl shadow mt-8 overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h5 class="text-lg font-semibold">Recent Orders</h5>
        </div>
        <div class="p-6 overflow-x-auto">
            <?php if (!empty($recentOrders)) : ?>
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">User</th>
                            <!-- <th class="px-4 py-2 border">Product</th> -->
                            <th class="px-4 py-2 border">Total Amout</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border"><?= $order['order_id'] ?></td>
                                <td class="px-4 py-2 border"><?= $order['user_name'] ?></td>
                                <!-- <td class="px-4 py-2 border">$<?= number_format($order['total_amount'], 2) ?></td> -->
                                <td class="px-4 py-2 border">$<?= number_format($order['total_amount'], 2) ?></td>
                                <td class="px-4 py-2 border"><?= $order['status'] ?></td>
                                <td class="px-4 py-2 border"><?= $order['order_date'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-gray-500">No recent orders found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
