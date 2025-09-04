<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="bg-white shadow-md rounded-lg p-5 mb-6 border">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Order #<?= htmlspecialchars($order['order_id']) ?></h2>
                    <span class="px-3 py-1 rounded-full text-sm 
                        <?= $order['order_status'] === 'Completed' ? 'bg-green-100 text-green-700' : 
                            ($order['order_status'] === 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
                        <?= htmlspecialchars($order['order_status']) ?>
                    </span>
                </div>

                <p class="text-gray-600 text-sm mb-2">
                    Date: <?= htmlspecialchars($order['order_date']) ?>
                </p>
                <p class="text-gray-800 font-medium mb-4">
                    Total: $<?= number_format($order['total_amount'], 2) ?>
                </p>

                <!-- Order Items -->
                <?php if (!empty($orderitems[$order['order_id']])): ?>
                    <table class="w-full text-left border border-gray-200 mb-4">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="py-2 px-3 border">Product</th>
                                <th class="py-2 px-3 border">Qty</th>
                                <th class="py-2 px-3 border">Price</th>
                                <th class="py-2 px-3 border">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderitems[$order['order_id']] as $item): ?>
                                <tr>
                                    <td class="py-2 px-3 border"><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td class="py-2 px-3 border"><?= (int)$item['quantity'] ?></td>
                                    <td class="py-2 px-3 border">$<?= number_format($item['price'], 2) ?></td>
                                    <td class="py-2 px-3 border">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-gray-500">No items found in this order.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-500">You have not placed any orders yet.</p>
    <?php endif; ?>
</div>
