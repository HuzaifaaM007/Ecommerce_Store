<!-- views/user/place_order.php -->
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <strong class="font-bold">✅ Order Placed Successfully!</strong>
        <span class="block sm:inline"> Thank you for your purchase.</span>
    </div>

    <!-- Order Details -->
    <?php $order_Values = []; ?>

    <?php foreach ($order as $orders_value): ?>
        <?php $order_Values = $orders_value ?>



        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Order Details</h2>
            <p><span class="font-semibold">Order ID:</span> #<?= $order_Values['order_id'] ?></p>
            <p><span class="font-semibold">Order Date:</span> <?= $order_Values['order_date'] ?></p>
            <p><span class="font-semibold">Order Status:</span>
                <span class="px-2 py-1 rounded bg-blue-100 text-blue-800"><?= ucfirst($order_Values['order_status']) ?></span>
            </p>
            <p><span class="font-semibold">Total Amount:</span> $<?= number_format($order_Values['total_amount'], 2) ?></p>
        </div>

        <!-- Shipping Method -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Shipping Information</h2>
            <p><span class="font-semibold">Shipping Method:</span> <?= htmlspecialchars($order_Values['shipping_method']) ?></p>
            <p><span class="font-semibold">Estimated Delivery:</span> <?= $order_Values['estimated_days'] ?> days</p>
            <p><span class="font-semibold">Shipping Cost:</span> $<?= number_format($order_Values['shipping_cost'], 2) ?></p>
        </div>

        <!-- Payment Method -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
            <p><span class="font-semibold">Payment Method:</span> <?= strtoupper($order_Values['payment_method']) ?></p>
            <p><span class="font-semibold">Transaction ID:</span> <?= $order_Values['transaction_id'] ?? 'N/A' ?></p>
            <p><span class="font-semibold">Payment Status:</span>
                <span class="px-2 py-1 rounded bg-green-100 text-green-800"><?= ucfirst($order_Values['payment_status']) ?></span>
            </p>
        </div>

    <?php endforeach; ?>
    <!-- Ordered Products -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Products Ordered</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left py-2 px-3">Product</th>
                    <th class="text-left py-2 px-3">Price</th>
                    <th class="text-left py-2 px-3">Quantity</th>
                    <th class="text-left py-2 px-3">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                    <?php $subtotal = $item['price'] * $item['quantity']; ?>
                    <tr class="border-b">
                        <td class="py-2 px-3"><?= htmlspecialchars($item['product_name']) ?></td>
                        <td class="py-2 px-3">$<?= number_format($item['price'], 2) ?></td>
                        <td class="py-2 px-3"><?= $item['quantity'] ?></td>
                        <td class="py-2 px-3">$<?= number_format($subtotal, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Back to Orders Button -->
    <div class="mt-6 text-center">
        <a href="index.php?page=user_orders&user_id=<?= $order_Values['user_id'] ?>" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            View My Orders
        </a>
    </div>
</div>