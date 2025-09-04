<!-- views/admin/orders.php -->


<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Pending Orders</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="text-lg font-semibold">Orders List</h3>
        </div>

        <?php if (!empty($orders)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($orders as $order): ?>
                            <?php if ($order['status'] === 'pending'): ?>
                                <!-- Order Row -->
                                <tr class="bg-yellow-50">
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_id'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['user_name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800">$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                            <?= $order['status'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_date'] ?></td>
                                    <td class="px-6 py-4 text-sm flex gap-2 items-center">
                                        <!-- View Button -->
                                        <a href="index.php?page=order_details&id=<?= $order['order_id'] ?>"
                                            class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 shadow-sm transition">
                                            View
                                        </a>

                                        <!-- Status Dropdown (numeric values) -->
                                        <select
                                            onchange="if(this.value) window.location.href='index.php?page=update_order&id=<?= $order['order_id'] ?>&option='+this.value"
                                            class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 shadow-sm 
               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                            <option value="">Update Status</option>
                                            <option value="1" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="2" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                                            <option value="3" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                            <option value="4" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Delivered</option>
                                            <option value="5" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>

                                        <!-- Delete Button -->
                                        <a href="index.php?page=delete_order&id=<?= $order['order_id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this order?');"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-sm transition">
                                            Delete
                                        </a>
                                    </td>

                                </tr>

                                <!-- Order Items Row -->
                                <?php if (!empty($order_items[$order['order_id']])): ?>
                                    <tr class="bg-gray-50">
                                        <td colspan="6" class="px-6 py-4">
                                            <table class="w-full border text-sm">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="px-3 py-2 border">Product</th>
                                                        <th class="px-3 py-2 border">Quantity</th>
                                                        <th class="px-3 py-2 border">Price</th>
                                                        <th class="px-3 py-2 border">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($order_items[$order['order_id']] as $item): ?>
                                                        <tr>
                                                            <td class="px-3 py-2 border"><?= htmlspecialchars($item['product_name']) ?></td>
                                                            <td class="px-3 py-2 border"><?= (int)$item['quantity'] ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'], 2) ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-3 text-gray-500">No items for this order.</td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="p-4 text-gray-600">No pending orders found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Processing Orders -->


<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Processing Orders</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="text-lg font-semibold">Orders List</h3>
        </div>

        <?php if (!empty($orders)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($orders as $order): ?>
                            <?php if ($order['status'] === 'processing'): ?>
                                <!-- Order Row -->
                                <tr class="bg-yellow-50">
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_id'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['user_name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800">$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                            <?= $order['status'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_date'] ?></td>
                                    <td class="px-6 py-4 text-sm flex gap-2 items-center">
                                        <!-- View Button -->
                                        <a href="index.php?page=order_details&id=<?= $order['order_id'] ?>"
                                            class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 shadow-sm transition">
                                            View
                                        </a>

                                        <!-- Status Dropdown (numeric values) -->
                                        <select
                                            onchange="if(this.value) window.location.href='index.php?page=update_order&id=<?= $order['order_id'] ?>&option='+this.value"
                                            class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 shadow-sm 
               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                            <option value="">Processing</option>
                                            <option value="3" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                            <option value="4" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Delivered</option>
                                            <option value="5" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                       
                                           </select>

                                        <!-- Delete Button -->
                                        <a href="index.php?page=delete_order&id=<?= $order['order_id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this order?');"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-sm transition">
                                            Delete
                                        </a>
                                    </td>

                                </tr>

                                <!-- Order Items Row -->
                                <?php if (!empty($order_items[$order['order_id']])): ?>
                                    <tr class="bg-gray-50">
                                        <td colspan="6" class="px-6 py-4">
                                            <table class="w-full border text-sm">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="px-3 py-2 border">Product</th>
                                                        <th class="px-3 py-2 border">Quantity</th>
                                                        <th class="px-3 py-2 border">Price</th>
                                                        <th class="px-3 py-2 border">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($order_items[$order['order_id']] as $item): ?>
                                                        <tr>
                                                            <td class="px-3 py-2 border"><?= htmlspecialchars($item['product_name']) ?></td>
                                                            <td class="px-3 py-2 border"><?= (int)$item['quantity'] ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'], 2) ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-3 text-gray-500">No items for this order.</td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="p-4 text-gray-600">No processing orders found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- shipped Orders -->


<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Shipped Orders</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="text-lg font-semibold">Orders List</h3>
        </div>

        <?php if (!empty($orders)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($orders as $order): ?>
                            <?php if ($order['status'] === 'shipped'): ?>
                                <!-- Order Row -->
                                <tr class="bg-yellow-50">
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_id'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['user_name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800">$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                            <?= $order['status'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_date'] ?></td>
                                    <td class="px-6 py-4 text-sm flex gap-2 items-center">
                                        <!-- View Button -->
                                        <a href="index.php?page=order_details&id=<?= $order['order_id'] ?>"
                                            class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 shadow-sm transition">
                                            View
                                        </a>

                                        <!-- Status Dropdown (numeric values) -->
                                        <select
                                            onchange="if(this.value) window.location.href='index.php?page=update_order&id=<?= $order['order_id'] ?>&option='+this.value"
                                            class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 shadow-sm 
               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                            <option value="">Shipped</option>
                                            <option value="4" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Delivered</option>
                                            <option value="5" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>

                                        <!-- Delete Button -->
                                        <a href="index.php?page=delete_order&id=<?= $order['order_id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this order?');"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-sm transition">
                                            Delete
                                        </a>
                                    </td>

                                </tr>

                                <!-- Order Items Row -->
                                <?php if (!empty($order_items[$order['order_id']])): ?>
                                    <tr class="bg-gray-50">
                                        <td colspan="6" class="px-6 py-4">
                                            <table class="w-full border text-sm">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="px-3 py-2 border">Product</th>
                                                        <th class="px-3 py-2 border">Quantity</th>
                                                        <th class="px-3 py-2 border">Price</th>
                                                        <th class="px-3 py-2 border">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($order_items[$order['order_id']] as $item): ?>
                                                        <tr>
                                                            <td class="px-3 py-2 border"><?= htmlspecialchars($item['product_name']) ?></td>
                                                            <td class="px-3 py-2 border"><?= (int)$item['quantity'] ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'], 2) ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-3 text-gray-500">No items for this order.</td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="p-4 text-gray-600">No Shipped orders found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Completed Orders -->

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Delivered Orders</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="text-lg font-semibold">Orders List</h3>
        </div>

        <?php if (!empty($orders)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($orders as $order): ?>
                            <?php if ($order['status'] === 'delivered'): ?>
                                <!-- Order Row -->
                                <tr class="bg-yellow-50">
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_id'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['user_name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800">$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                            <?= $order['status'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_date'] ?></td>
                                    <td class="px-6 py-4 text-sm flex gap-2 items-center">
                                        <!-- View Button -->
                                        <a href="index.php?page=order_details&id=<?= $order['order_id'] ?>"
                                            class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 shadow-sm transition">
                                            View
                                        </a>

                                        <!-- Status Dropdown (numeric values) -->
                                        <select
                                            onchange="if(this.value) window.location.href='index.php?page=update_order&id=<?= $order['order_id'] ?>&option='+this.value"
                                            class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 shadow-sm 
               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                            <option value="">Delivered</option>
                                           </select>

                                        <!-- Delete Button -->
                                        <a href="index.php?page=delete_order&id=<?= $order['order_id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this order?');"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-sm transition">
                                            Delete
                                        </a>
                                    </td>

                                </tr>

                                <!-- Order Items Row -->
                                <?php if (!empty($order_items[$order['order_id']])): ?>
                                    <tr class="bg-gray-50">
                                        <td colspan="6" class="px-6 py-4">
                                            <table class="w-full border text-sm">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="px-3 py-2 border">Product</th>
                                                        <th class="px-3 py-2 border">Quantity</th>
                                                        <th class="px-3 py-2 border">Price</th>
                                                        <th class="px-3 py-2 border">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($order_items[$order['order_id']] as $item): ?>
                                                        <tr>
                                                            <td class="px-3 py-2 border"><?= htmlspecialchars($item['product_name']) ?></td>
                                                            <td class="px-3 py-2 border"><?= (int)$item['quantity'] ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'], 2) ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-3 text-gray-500">No items for this order.</td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="p-4 text-gray-600">No delivered orders found.</p>
        <?php endif; ?>
    </div>
</div>

            

<!-- Cancelled Orders -->


<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Cancelled Orders</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="text-lg font-semibold">Orders List</h3>
        </div>

        <?php if (!empty($orders)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($orders as $order): ?>
                            <?php if ($order['status'] === 'cancelled'): ?>
                                <!-- Order Row -->
                                <tr class="bg-yellow-50">
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_id'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['user_name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800">$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                            <?= $order['status'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?= $order['order_date'] ?></td>
                                    <td class="px-6 py-4 text-sm flex gap-2 items-center">
                                        <!-- View Button -->
                                        <a href="index.php?page=order_details&id=<?= $order['order_id'] ?>"
                                            class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 shadow-sm transition">
                                            View
                                        </a>

                                        <!-- Status Dropdown (numeric values) -->
                                        <select
                                            onchange="if(this.value) window.location.href='index.php?page=update_order&id=<?= $order['order_id'] ?>&option='+this.value"
                                            class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 shadow-sm 
               focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                            <option value="">Cancelled</option>
                                             </select>

                                        <!-- Delete Button -->
                                        <a href="index.php?page=delete_order&id=<?= $order['order_id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this order?');"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-sm transition">
                                            Delete
                                        </a>
                                    </td>

                                </tr>

                                <!-- Order Items Row -->
                                <?php if (!empty($order_items[$order['order_id']])): ?>
                                    <tr class="bg-gray-50">
                                        <td colspan="6" class="px-6 py-4">
                                            <table class="w-full border text-sm">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="px-3 py-2 border">Product</th>
                                                        <th class="px-3 py-2 border">Quantity</th>
                                                        <th class="px-3 py-2 border">Price</th>
                                                        <th class="px-3 py-2 border">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($order_items[$order['order_id']] as $item): ?>
                                                        <tr>
                                                            <td class="px-3 py-2 border"><?= htmlspecialchars($item['product_name']) ?></td>
                                                            <td class="px-3 py-2 border"><?= (int)$item['quantity'] ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'], 2) ?></td>
                                                            <td class="px-3 py-2 border">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-3 text-gray-500">No items for this order.</td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="p-4 text-gray-600">No Cancelled orders found.</p>
        <?php endif; ?>
    </div>
</div>



